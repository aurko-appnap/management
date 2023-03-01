<?php

namespace App\Filament\Resources\CategoryResource\Pages;

use Filament\Resources\Table;
use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CategoryResource;

class OrderSummary extends Page
{
    protected static string $resource = CategoryResource::class;
    public $OrderSummary;
    public $catID;
    public $totalOrderCount;

    public $totalPageCount;
    public $page;

    public $fromDate, $toDate;
    public $numberOfProduct = 0;

    public function mount()
    {
        if(request('from') != NULL)
        {
            $this->fromDate = Carbon::createFromFormat('d/m/Y', request('from')); 
            $this->toDate = Carbon::createFromFormat('d/m/Y', request('to')); 
            $perPageRecord = 500000;
        }
        else
        {
            $this->fromDate = Carbon::createFromFormat('d/m/Y', "01/01/1990"); 
            $this->toDate = Carbon::now();
            $perPageRecord = 5;
        }

        $this->catID = request('record');
        
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
            ->whereDate('orders.order_placed_on' , '>=' , $this->fromDate)
            ->whereDate('orders.order_placed_on' , '<=' , $this->toDate)
            ->where('categories.id' , $this->catID)
            ->limit($perPageRecord)
            ->offset($pageRecordStart)
            ->get();
            // dd($this->OrderSummary);
            $individualProductCount = DB::table('order_items')
                ->join('products' , 'products.id' , '=' , 'order_items.product_id')
                ->join('orders' , 'orders.id' , '=' , 'order_items.order_id')
                ->select('order_items.product_quantity')
                ->where('products.category_id' , $this->catID)
                ->whereDate('orders.order_placed_on' , '>=' , $this->fromDate)
                ->whereDate('orders.order_placed_on' , '<=' , $this->toDate)
                ->get();
            foreach($individualProductCount as $key => $pCount)
                $this->numberOfProduct = $this->numberOfProduct + $pCount->product_quantity;
    
            if(request('from') != NULL)
                $this->totalOrderCount = sizeof($this->OrderSummary);
            else    
                $this->totalOrderCount = sizeof($OrderSummaryRecord);
    
    }

    protected static string $view = 'filament.resources.category-resource.pages.order-summary';
}
