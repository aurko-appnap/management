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
    public $catID;
    public $totalPageCount;
    public $page;

    public function mount()
    {
        $this->catID = request('record');
        $perPageRecord = 5;
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $OrderSummaryRecord = DB::table('orders')
            ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
            ->join('customers' , 'customers.id' , '=' , 'orders.customer_code')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->join('categories' , 'categories.id' , '=' , 'products.category_id')
            ->select('orders.*' , 'customers.name')
            ->where('categories.id' , $this->catID)
            ->get();
        
        $this->totalPageCount = (int)ceil(sizeof($OrderSummaryRecord) / $perPageRecord);

        
        $this->OrderSummary = DB::table('orders')
            ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
            ->join('customers' , 'customers.id' , '=' , 'orders.customer_code')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->join('categories' , 'categories.id' , '=' , 'products.category_id')
            ->select('orders.*' , 'customers.name')
            ->where('categories.id' , $this->catID)
            ->limit($perPageRecord)
            ->offset($pageRecordStart)
            ->get();
    }

    protected static string $view = 'filament.resources.category-resource.pages.order-summary';
}
