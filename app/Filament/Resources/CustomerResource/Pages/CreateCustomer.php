<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Filament\Pages\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\CustomerResource;

class CreateCustomer extends CreateRecord
{
    protected static string $resource = CustomerResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Success')
            ->body('New customer created.');
    }
}
