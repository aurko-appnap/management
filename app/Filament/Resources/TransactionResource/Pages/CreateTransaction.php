<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Models\Order;
use App\Models\Transaction;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;
use Filament\Pages\Actions\CreateAction;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\TransactionResource;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function getCreatedNotification(): ?Notification
    {
        return Notification::make()
            ->success()
            ->title('Payment Received')
            ->body('Your payment has been received.');
    }

    // protected function mutateFormDataBeforeCreate(array $data): array
    // {
    //     $order = Order::where('order_number' , '=' , $data['order'])->first();
    //     if($data['transaction_amount'] > $order->total_price)
    //         {
    //             return Notification::make()
    //                     ->success()
    //                     ->title('Sorry!')
    //                     ->body('-----')
    //                     ->cancel();
    //         }
    //     else
    //         return $data;
    // }

    protected function handleRecordCreation(array $data): Model
    {
        $order = Order::where('order_number' , '=' , $data['order'])->first();

        $data['order_id'] = $order->id;
        $data['entity_type'] = 'customer';
        $data['transaction_type'] = 'debit';

        static::getModel()::create($data);

        $data['order_id'] = $order->id;
        $data['entity_type'] = 'company';
        $data['transaction_type'] = 'credit';

        $total_paid = Transaction::where('order_id' , $order->id)
                        ->where('entity_type' , 'customer')
                        ->sum('transaction_amount');

        if($order->total_price == $total_paid)
            Order::where('id' , $order->id)->update(['order_status' => '3']);
        else if($order->total_price < $total_paid)
            Order::where('id' , $order->id)->update(['order_status' => '2']);
        else if($order->total_price > $total_paid)
            Order::where('id' , $order->id)->update(['order_status' => '1']);
        else{}

        return static::getModel()::create($data);
    }
}
