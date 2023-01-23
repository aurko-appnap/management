<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use App\Models\Product;
use App\Models\Category;
use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;
use App\Filament\Resources\CategoryResource;

class EditCategory extends EditRecord
{
    protected static string $resource = CategoryResource::class;

    protected function getActions(): array
    {
        return [
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
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
