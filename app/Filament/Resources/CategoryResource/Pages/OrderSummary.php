<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CategoryResource;

class OrderSummary extends Page
{
    protected static string $resource = CategoryResource::class;
    public $OrderSummary;
    public $categoryDetail;
    
    public function mount()
    {
        $catID = request('record');
        $this->OrderSummary = DB::table('orders')
            ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
            ->join('customers' , 'customers.id' , '=' , 'orders.customer_code')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->join('categories' , 'categories.id' , '=' , 'products.category_id')
            ->select('orders.*' , 'customers.name')
            ->where('categories.id' , $catID)
            ->get();
        
        // $this->categoryDetail = DB::table('categories')
        //     ->select('name')
        //     ->where('id', $catID)
        //     ->first();
    }
    protected static string $view = 'filament.resources.category-resource.pages.order-summary';
}
