<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use App\Models\Product;
use Filament\Pages\Actions;
use Illuminate\Database\Eloquent\Model;
use Filament\Resources\Pages\CreateRecord;
use App\Filament\Resources\PurchaseResource;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;
    protected function getRedirectUrl(): string
    {
        return $this->previousUrl;
    }

    protected function handleRecordCreation(array $data): Model
    {
        $data['purchase_status'] = '0';
        $data['company_id'] = '1';
        $total_price = 0;
        $items = $this->data['PurchaseItem'];

        foreach ($items as $key => $item)
        {
            $product = Product::find($item['product_id']);
            $updated_inventory = $product->inventory + $item['product_quantity'];
            Product::where('id' , $item['product_id'])
                ->update(['inventory' => $updated_inventory]);
        }
            
        foreach ($items as $key => $item)
            $total_price = $total_price + $item['product_total_price'];
        
        $data['total_purchased_price']=$total_price;
        return static::getModel()::create($data);
    }
}
