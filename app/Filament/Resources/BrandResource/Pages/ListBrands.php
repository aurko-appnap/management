<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Filament\Resources\BrandResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\ListRecords;

class ListBrands extends ListRecords
{
    protected static string $resource = BrandResource::class;
    
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
