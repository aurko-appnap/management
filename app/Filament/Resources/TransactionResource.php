<?php

namespace App\Filament\Resources;

use Filament\Forms;
use Filament\Tables;
use App\Models\Order;
use App\Models\Transaction;
use Filament\Resources\Form;
use Illuminate\Http\Request;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Illuminate\Database\Eloquent\Builder;
use Symfony\Component\Console\Input\Input;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationGroup = 'Finance';
    protected static ?string $navigationIcon = 'heroicon-o-currency-dollar';

    public static function form(Form $form): Form
    { 
        return $form
            ->schema([
                Card::make()->schema([
                    Card::make()->schema([
                        TextInput::make('order')
                            ->default(request()->get('order'))
                            ->required()
                            ->disabled(),

                        Select::make('transaction_method')
                            ->options(([
                                'bkash' => 'BKash',
                                'nagad' => 'Nagad',
                                'visa' => 'Visa',
                                'mastercard' => 'Master Card',
                                'nexuspay' => 'Nexus Pay',
                            ])),
                        TextInput::make('transaction_amount')
                            ->prefix('BDT')
                            ->mask(fn (TextInput\Mask $mask) => $mask
                                ->numeric()
                                ->thousandsSeparator(',')
                                ->mapToDecimalSeparator(['.'])
                            )
                            ->afterStateUpdated(function ($state, callable $get){
                                $order = Order::where('order_number' , '=' , $get('order'))->first();
                                if($order->total_price < $state)
                                {
                                    
                                }
                            }),
                    ])->columns(3),
                    TextInput::make('transaction_message'),
                ]),
                

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
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
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }    
}
