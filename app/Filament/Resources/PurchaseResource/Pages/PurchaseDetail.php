<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\PurchaseResource;

class PurchaseDetail extends Page
{
    protected static string $resource = PurchaseResource::class;
    public $purchaseDetail;
    public function mount()
    {
        $this->purchaseDetail = DB::table('purchase_items')
                    ->join('products' , 'products.id' , '=' , 'purchase_items.product_id')
                    ->select('purchase_items.*' , 'products.name')
                    ->where('purchase_items.purchase_id' , request('record'))
                    ->get();
        
    }
    protected static string $view = 'filament.resources.purchase-resource.pages.purchase-detail';
}
