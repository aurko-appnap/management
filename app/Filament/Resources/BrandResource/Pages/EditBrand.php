<?php

namespace App\Filament\Resources\BrandResource\Pages;

use App\Models\Product;
use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\BrandResource;
use App\Models\Brand;
use Filament\Notifications\Actions\Action;

class EditBrand extends EditRecord
{
    protected static string $resource = BrandResource::class;

    protected function getActions(): array
    {
        return [
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

            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
