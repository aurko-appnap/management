<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\OrderResource;

class DetailOrder extends Page
{   
    protected static string $resource = OrderResource::class;
    public $OrderDetailSummary, $orderId;

    public $totalPageCount;
    public $page;

    public function mount()
    {
        $this->orderId = request('record');

        $perPageRecord = 5;
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $OrderDetailSummaryRecord = DB::table('order_items')
            ->join('products' , 'order_items.product_id' , '=' , 'products.id')
            ->select('order_items.*' , 'products.name', 'products.price')
            ->where('order_items.order_id' , request('record'))
            ->get();

        $this->totalPageCount = (int)ceil(sizeof($OrderDetailSummaryRecord) / $perPageRecord);

        $this->OrderDetailSummary = DB::table('order_items')
            ->join('products' , 'order_items.product_id' , '=' , 'products.id')
            ->select('order_items.*' , 'products.name', 'products.price')
            ->where('order_items.order_id' , request('record'))
            ->limit($perPageRecord)
            ->offset($pageRecordStart)
            ->get();
    }
    
    protected static string $view = 'filament.resources.order-resource.pages.order-detail';
}
