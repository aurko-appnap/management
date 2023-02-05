<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Product;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\OrderResource;
use Filament\Resources\Pages\CreateRecord;


class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    
    protected function handleRecordCreation(array $data): Model
    {
        $data['user_id'] = auth()->id();
        $total_price = 0;
        $items = $this->data['OrderItem'];

        foreach ($items as $key => $item)
            $total_price = $total_price + $item['total_price'];
        
        $data['total_price']=$total_price;
        $data['order_status']=0;

        foreach ($items as $key => $item)
        {
            $product = Product::find($item['product_id']);
            $updated_inventory = $product->inventory - $item['product_quantity'];
            Product::where('id' , $item['product_id'])
                ->update(['inventory' => $updated_inventory]);
        }
        
        return static::getModel()::create($data);
    }
}
