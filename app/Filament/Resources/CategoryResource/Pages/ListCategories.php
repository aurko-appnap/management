<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Filament\Resources\CategoryResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListCategories extends ListRecords
{
    protected static string $resource = CategoryResource::class;
    
    protected function getDefaultTableSortColumn(): ?string
    {
        return 'id';
    }
 
    protected function getDefaultTableSortDirection(): ?string
    {
        return 'desc';
    }
    protected function getActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
