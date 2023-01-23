<?php

namespace App\Filament\Resources;


use Closure;
use Filament\Forms;
use Filament\Tables;
use App\Models\Brand;
use App\Models\Product;
use Illuminate\Support\Str;
use App\Enums\ProductStatus;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\ProductResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Category;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    TextInput::make('name')
                    ->label('Product Name')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function (Closure $set, $state) {
                        $set('slug', Str::slug($state));
                    }),
                TextInput::make('slug'),
                ])
                ->columns(2),

                Card::make()->schema([
                    Select::make('category_id')
                        ->relationship('category', 'name', fn (Builder $query) => Category::where('deleted_at' , NULL))
                        ->required(),
                    
                    Select::make('brand_id')
                        ->relationship('brand', 'name', fn (Builder $query) => Brand::where('deleted_at' , NULL))
                        ->required(),
                    
                    RichEditor::make('product_description')
                        ->required(),

                    TextInput::make('price')
                        ->mask(fn (TextInput\Mask $mask) => $mask
                        ->money(prefix: 'BDT ', thousandsSeparator: ',', decimalPlaces: 2)),
                ]),

                Card::make()->schema([
                    SpatieMediaLibraryFileUpload::make('thumbnail')
                        ->collection('display_pictures'),
                ]),
                 
                Toggle::make('is_available')->inline(true)
                        ->default(1)
                        ->onColor('success')
                        ->offColor('danger'),

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('display_pictures')
                ->label('Picture'),
                TextColumn::make('name'),
                TextColumn::make('category.name'),
                TextColumn::make('price')
                    ->sortable()
                    ->money('BDT'),
                TextColumn::make('brand.name'),
                BadgeColumn::make('is_available')
                    ->label('Availability')
                    ->sortable()
                    ->enum(collect(ProductStatus::cases())
                        ->mapWithKeys(fn($item) => [$item->value => $item->name()])
                        ->toArray())
                    ->color(function ($state) {
                        $options = collect(ProductStatus::cases())
                            ->mapWithKeys(fn($item) => [$item->value => $item->color()])
                            ->toArray();
                        return isset($options[$state]) ? $options[$state] : '';
                    })
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
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
                SoftDeletingScope::class,
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
