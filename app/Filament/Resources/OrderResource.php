<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Product;
use App\Enums\OrderStatus;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Repeater;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\Placeholder;
use App\Filament\Resources\OrderResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\OrderResource\RelationManagers;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-plus-circle';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Card::make()->schema([
                        TextInput::make('order_number')
                            ->label('Order Number')
                            ->default('APPNAP-'. random_int(1000,9999))
                            ->required()
                            ->disabled(),
                        
                        DatePicker::make('order_placed_on')
                                ->label('Order Date')
                                ->default(now())
                                ->required(),
                    
                        Select::make('shipping_method')
                            ->label('Select Shipping Method')
                            ->required()
                            ->options([
                                'redex' => 'RedEx',
                                'sundarban' => 'Sundarban Courier',
                                'peperfly' => 'Peperfly',
                            ]),
                    ])->columns(3),
                
                    TextInput::make('shipping_address')
                        ->label('Shipping Address'),
                ]),
                Card::make()->schema([
                    Placeholder::make('Choose Products'),
                    Repeater::make('OrderItem')
                        ->relationship()
                        ->schema([
                            Select::make('product_id')
                                ->label('Product')
                                ->options(Product::query()->pluck('name' , 'id'))
                                ->reactive()
                                ->afterStateUpdated(function($state , callable $set,  callable $get){
                                    $product = Product::find($state);
                                    if($product)
                                    {
                                        $set('price' , $product->price);
                                        $set('product_price' , $product->price);
                                        $set('total_price_product', $get('product_quantity')*$product->price);
                                    }
                                })
                                ->required(),

                            TextInput::make('product_quantity')
                                ->label('Quantity')
                                ->integer()
                                ->minValue(1)
                                ->required()
                                ->reactive()
                                ->afterStateUpdated(function($state , callable $set, callable $get){
                                    $set('total_price_product', $get('price')*$state);
                                }),
                                        
                            
                            TextInput::make('price')
                                ->label('Unit Price')
                                ->prefix('৳ ')
                                ->mask(fn (TextInput\Mask $mask) => $mask
                                    ->numeric()
                                    ->thousandsSeparator(',')
                                    ->mapToDecimalSeparator(['.'])
                                )
                                ->disabled()
                                ->dehydrated(false),

                            Hidden::make('product_price'),

                            TextInput::make('total_price_product')
                                ->disabled(),
                                
                        ])
                        ->cloneable()
                        ->columns(4)
                        ->createItemButtonLabel('Add More Product')
                    ]),
                    Hidden::make('total_price'),
                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_number'),

                BadgeColumn::make('order_status')
                    ->label('Activity')
                    ->sortable()
                    ->enum(collect(OrderStatus::cases())
                        ->mapWithKeys(fn($item) => [$item->value => $item->name()])
                        ->toArray())
                    ->color(function ($state) {
                        $options = collect(OrderStatus::cases())
                            ->mapWithKeys(fn($item) => [$item->value => $item->color()])
                            ->toArray();
                        return isset($options[$state]) ? $options[$state] : '';
                    }),

                TextColumn::make('shipping_method')->enum([
                    'redex' => 'RedEx',
                    'sundarban' => 'Sundarban Courier',
                    'peperfly' => 'Peperfly',
                ]),

                TextColumn::make('total_price')
                    ->money('BDT'),
                TextColumn::make('order_placed_on')
                    ->sortable()
                    ->date('d/m/Y'),
                
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
            ])->defaultSort('id' , 'desc');
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
            'index' => Pages\ListOrders::route('/'),
            'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }    
}
