<?php

namespace App\Filament\Resources;

use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Filament\Resources\Form;
use App\Enums\CategoryStatus;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Tables\Actions\Action;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Notifications\Notification;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Actions\DeleteAction;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\CategoryResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\CategoryResource\RelationManagers;
use App\Filament\Resources\CategoryResource\Pages\OrderSummary;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                        ->label('Category Name')
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
                        ->collection('category_picture'),
                ]),
                    
                Card::make()->schema([
                    RichEditor::make('description')
                        ->label('Category Description')
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
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('category_picture')
                ->label('Picture'),

                TextColumn::make('name')
                    ->label('Category Name'),
                
                BadgeColumn::make('status')
                    ->label('Activity')
                    ->sortable()
                    ->enum(collect(CategoryStatus::cases())
                        ->mapWithKeys(fn($item) => [$item->value => $item->name()])
                        ->toArray())
                    ->color(function ($state) {
                        $options = collect(CategoryStatus::cases())
                            ->mapWithKeys(fn($item) => [$item->value => $item->color()])
                            ->toArray();
                        return isset($options[$state]) ? $options[$state] : '';
                    })
                ])->defaultSort('id' , 'desc')
            ->filters([
                //
            ])
            ->actions([
                ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    DeleteAction::make()
                        ->before(function (Category $record, DeleteAction $action)
                        {
                            // dd($record);
                            $temp = Product::where('category_id' , $record->id)->count();
                            if($temp != 0)
                                {
                                    Notification::make()
                                        ->warning()
                                        ->title('Sorry!')
                                        ->body('This category isn\'t empty!')
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
                        ->url(fn (Category $record):string => '/admin/categories/order-detail/'.$record['id']),
                ])
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
            ]);
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
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
            'order-summary' => OrderSummary::route('/order-detail/{record}')
        ];
    }    
}
