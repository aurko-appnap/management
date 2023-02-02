<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Company;
use App\Models\Product;
use App\Models\Purchase;
use App\Models\Supplier;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\PurchaseResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PurchaseResource\RelationManagers;

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
                            ->label('Supplier Name')
                            ->options(Supplier::all()->pluck('name' , 'id')),
                    
                    Select::make('company_id')
                            ->label('Company Name')
                            ->options(Company::all()->pluck('name' , 'id')),
                ])->columns(3),

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
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
