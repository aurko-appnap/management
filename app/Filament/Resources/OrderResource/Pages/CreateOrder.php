<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;


class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = auth()->id();
        $total_price = 0;
        $items = $this->data['OrderItem'];

        foreach ($items as $key => $item)
            $total_price = $total_price + $item['total_price_product'];
        
        $data['total_price']=$total_price;
        $data['order_status']=0;
        return static::getModel()::create($data);
    }
}
