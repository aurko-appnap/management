<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Product;
use App\Enums\BrandStatus;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\Toggle;
use Filament\Pages\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\BrandResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\BrandResource\RelationManagers;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\BrandResource\Pages\OrderSummary;

class BrandResource extends Resource
{
    protected static ?string $model = Brand::class;

    protected static ?string $navigationIcon = 'heroicon-o-identification';
    protected static ?string $navigationGroup = 'Management';


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label('Brand Name')
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->reactive()
                        ->afterStateUpdated(function (Closure $set, $state) {
                            $set('slug', Str::slug($state));
                        }),
                        TextInput::make('slug'),
                ])->columns(2),

                Card::make()->schema([
                    SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->collection('brand_picture'),
                ]),
                    
                Card::make()->schema([
                    TextInput::make('website')
                        ->label('Company Website')
                        ->required(),

                    RichEditor::make('description')
                        ->label('Company Description')
                        ->required(),

                    Toggle::make('status')->inline(true)
                        ->default(1)
                        ->onColor('success')
                        ->offColor('danger'),
                ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name'),
                TextColumn::make('website'),
                BadgeColumn::make('status')
                    ->label('Activity')
                    ->sortable()
                    ->enum(collect(BrandStatus::cases())
                        ->mapWithKeys(fn($item) => [$item->value => $item->name()])
                        ->toArray())
                    ->color(function ($state) {
                        $options = collect(BrandStatus::cases())
                            ->mapWithKeys(fn($item) => [$item->value => $item->color()])
                            ->toArray();
                        return isset($options[$state]) ? $options[$state] : '';
                    })
            ])
            ->filters([
               //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    DeleteAction::make()
                    ->before(function (Brand $record, DeleteAction $action)
                    {
                        $temp = Product::where('brand_id' , $record->id)->count();
                        if($temp != 0)
                            {
                                Notification::make()
                                    ->warning()
                                    ->title('Sorry!')
                                    ->body('This brand isn\'t empty!')
                                    ->send();
                    
                                $action->cancel();
                            }
                    }),
                    Tables\Actions\ForceDeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                    Action::make('customer-order-summary')
                        ->label('Order Summary')
                        ->color('success')
                        ->icon('heroicon-o-book-open')
                        ->url(fn (Brand $record):string => '/admin/brands/order-detail/'.$record['id']),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ])->defaultSort('id' , 'desc');
            
    }
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                // SoftDeletingScope::class,
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
            'index' => Pages\ListBrands::route('/'),
            'create' => Pages\CreateBrand::route('/create'),
            'edit' => Pages\EditBrand::route('/{record}/edit'),
            'order-summary' => OrderSummary::route('/order-detail/{record}')
        ];
    }    
}
