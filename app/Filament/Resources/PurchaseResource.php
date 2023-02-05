<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Company;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Transaction;
use Filament\Resources\Form;
use App\Enums\PurchaseStatus;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PurchaseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PurchaseResource\RelationManagers;
use App\Models\PurchaseItem;

class PurchaseResource extends Resource
{
    protected static ?string $model = Purchase::class;

    protected static ?string $navigationIcon = 'heroicon-o-beaker';
    protected static ?string $navigationGroup = 'Finance';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('purchase_number')
                            ->label('Purchase Number')
                            ->default('PUR-'. random_int(1000,9999))
                            ->required()
                            ->disabled(),
                    Select::make('supplier_id')
                            ->required()
                            ->label('Supplier Name')
                            ->options(Supplier::all()->pluck('name' , 'id')),
                ])->columns(2),

                Card::make()->schema([
                    Placeholder::make('Choose Products'),
                    Repeater::make('PurchaseItem')
                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                                ->label('Product')
                                ->options(function($state, callable $get){
                                    $temp = [];
                                    foreach($get('../../PurchaseItem') as $item)
                                    {
                                        if($item['product_id'] != $state && $item['product_id'] != NULL)
                                        $temp[] = $item['product_id'];
                                    }
                                    
                                    return Product::whereNotIn('id' , $temp)->pluck('name' , 'id');
                                })
                                
                                ->reactive()
                                ->afterStateUpdated(function($state , callable $set,  callable $get){
                                    $product = Product::find($state);
                                    if($product)
                                    {
                                        $set('product_unit_price' , $product->price);
                                        $total_prices = $get('product_quantity')*$product->price;
                                        $set('product_total_price', $total_prices);
                                    }
                                })
                                ->required(),

                            TextInput::make('product_quantity')
                                ->label('Quantity')
                                ->integer()
                                ->default(1)
                                ->minValue(1)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function($state , callable $set, callable $get){
                                    $set('product_total_price', $get('product_unit_price')*$state);
                                }),
                                        
                            
                            TextInput::make('product_unit_price')
                                ->label('Unit Price')
                                ->prefix('BDT')
                                ->mask(fn (TextInput\Mask $mask) => $mask
                                    ->numeric()
                                    ->thousandsSeparator(',')
                                    ->mapToDecimalSeparator(['.'])
                                )
                                ->disabled(),

                            TextInput::make('product_total_price')
                                ->default(0)
                                ->label('Total Price')
                                ->prefix('BDT')
                                ->disabled(),
                                
                        ])
                        ->cloneable()
                        ->columns(4)
                        ->createItemButtonLabel('Add More Product')
                    ]),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('purchase_number'),

                BadgeColumn::make('purchase_status')
                    ->label('Payment Status')
                    ->sortable()
                    ->enum(collect(PurchaseStatus::cases())
                        ->mapWithKeys(fn($item) => [$item->value => $item->name()])
                        ->toArray())
                    ->color(function ($state) {
                        $options = collect(PurchaseStatus::cases())
                            ->mapWithKeys(fn($item) => [$item->value => $item->color()])
                            ->toArray();
                        return isset($options[$state]) ? $options[$state] : '';
                    }),
                
                TextColumn::make('supplier.name'),
                TextColumn::make('company.name'),

                TextColumn::make('total_purchased_price')
                    ->label('Purchase Price')
                    ->money('BDT'),

                TextColumn::make('payment')
                    ->formatStateUsing(function ($record){
                        return Transaction::where('trading_id' , $record->id)
                                    ->where('entity_type' , 'company')
                                    ->where('trading_type' , 'purchase')
                                    ->where('transaction_type' , 'debit')
                                    ->sum('transaction_amount');
                    }),
                

            ])->defaultSort('id' , 'desc')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),

                Action::make('payment')
                    ->label('Pay')
                    ->color('success')
                    ->icon('heroicon-o-currency-bangladeshi')
                    ->requiresConfirmation()
                    ->url(fn (Purchase $record): string => '/admin/transactions/create?order='.$record['purchase_number'].'&trading=purchase')
                    ->hidden(fn (Purchase $record):bool => $record['purchase_status'] == '2')
                    ->visible(fn (Purchase $record):bool => 
                    $record['total_purchased_price'] != Transaction::where('trading_id' , $record['id'])
                    ->where('entity_type' , 'company')
                    ->where('transaction_type' , 'debit')
                    ->sum('transaction_amount')),

                Action::make('cancel')
                    ->label('Cancel')
                    ->color('danger')
                    ->icon('heroicon-o-x-circle')
                    ->action(function (Purchase $record){
                        Purchase::where('id' , $record['id'])->update(['purchase_status' => '2']);
                        
                        $transaction = Transaction::where('trading_id' , $record['id'])
                                                    ->where('trading_type' , 'purchase')
                                                    ->first();
                        
                        $total_paid = Transaction::where('trading_id' , $record['id'])
                                                    ->where('entity_type' , 'company')
                                                    ->where('transaction_type' , 'debit')
                                                    ->sum('transaction_amount');

                        // dd($total_paid);
                        if($total_paid > 0)
                        {
                            Transaction::create([
                                'entity_id' => $transaction->entity_id,
                                'entity_type' => 'company',
                                'employee_id' => auth()->id(),
                                'trading_id' => $transaction->trading_id,
                                'trading_type' => 'purchase',
                                'transaction_type' => 'credit',
                                'transaction_amount' => $total_paid, //total payment created on this order
                                'transaction_message' => 'Purchase refund',
                                'transaction_method' => $transaction->transaction_method,
                            ]);

                            Transaction::create([
                                'entity_id' => '1',
                                'entity_type' => 'supplier',
                                'employee_id' => auth()->id(),
                                'trading_id' => $transaction->trading_id,
                                'trading_type' => 'purchase',
                                'transaction_type' => 'debit',
                                'transaction_amount' => $total_paid, //total payment created on this order
                                'transaction_message' => 'Purchase refund',
                                'transaction_method' => $transaction->transaction_method,
                            ]);
                        }

                        $purchase_items = PurchaseItem::where('purchase_id' , '=' , $record['id'])->get();
                        
                        foreach($purchase_items as $key => $item)
                            {
                                $product = Product::find($item->product_id);
                                $updated_inventory = $product->inventory - $item->product_quantity;
                                Product::where('id' , '=' , $item->product_id)
                                    ->update(['inventory' => $updated_inventory]);
                            }

                    })  
                    ->requiresConfirmation()
                    ->hidden(fn (Purchase $record):bool => $record['purchase_status'] == '2'),
                ])
                

                
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ]);
    }
    
    public static function getRelations(): array
    {
        return [
            //
        ];
    }
    
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPurchases::route('/'),
            'create' => Pages\CreatePurchase::route('/create'),
            'edit' => Pages\EditPurchase::route('/{record}/edit'),
        ];
    }    
}
