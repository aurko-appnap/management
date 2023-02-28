<?php

namespace App\Filament\Resources\BrandResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\BrandResource;
use Illuminate\Support\Carbon;

class OrderSummary extends Page
{
    protected static string $resource = BrandResource::class;
    public $OrderSummary;
    public $brandID;

    public $totalPageCount;
    public $page;

    public $fromDate, $toDate;

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
        $this->brandID = request('record');

        
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $OrderSummaryRecord = DB::table('orders')
            ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
            ->join('customers' , 'customers.id' , '=' , 'orders.customer_code')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->join('brands' , 'brands.id' , '=' , 'products.brand_id')
            ->select('orders.*' , 'customers.name')
            ->where('brands.id' , $this->brandID)
            ->get();
            $this->totalPageCount = (int)ceil(sizeof($OrderSummaryRecord) / $perPageRecord);

        $this->OrderSummary = DB::table('orders')
            ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
            ->join('customers' , 'customers.id' , '=' , 'orders.customer_code')
            ->join('products' , 'products.id' , '=' , 'order_items.product_id')
            ->join('brands' , 'brands.id' , '=' , 'products.brand_id')
            ->select('orders.*' , 'customers.name')
            ->where('brands.id' , $this->brandID)
            ->whereDate('orders.order_placed_on' , '>=' , $this->fromDate)
            ->whereDate('orders.order_placed_on' , '<=' , $this->toDate)
            ->limit($perPageRecord)
            ->offset($pageRecordStart)
            ->get();
    }
    protected static string $view = 'filament.resources.brand-resource.pages.order-summary';
}
