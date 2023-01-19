<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use Filament\Forms;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Closure;
use Illuminate\Support\Str;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\SelectFilter;


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
                    TextInput::make('category')
                        ->required(),
                    
                    Select::make('brand_id')
                        ->relationship('brand', 'name')
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
                ])

                
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('id')->sortable(),
                TextColumn::make('name'),
                TextColumn::make('category'),
                TextColumn::make('slug'),
                TextColumn::make('price'),
                TextColumn::make('brand.name'),
                SpatieMediaLibraryImageColumn::make('thumbnail')->collection('display_pictures'),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }    
}
