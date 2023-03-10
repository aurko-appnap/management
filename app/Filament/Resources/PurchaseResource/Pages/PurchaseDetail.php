<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\PurchaseResource;

class PurchaseDetail extends Page
{
    protected static string $resource = PurchaseResource::class;
    public $purchaseDetail, $purchaseId;

    public $totalPageCount;
    public $page;

    public function mount()
    {
        $this->purchaseId = request('record');

        $perPageRecord = 5;
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $purchaseDetailRecord = DB::table('purchase_items')
                    ->join('products' , 'products.id' , '=' , 'purchase_items.product_id')
                    ->select('purchase_items.*' , 'products.name')
                    ->where('purchase_items.purchase_id' , request('record'))
                    ->get();
        
        $this->totalPageCount = (int)ceil(sizeof($purchaseDetailRecord) / $perPageRecord);

        $this->purchaseDetail = DB::table('purchase_items')
                    ->join('products' , 'products.id' , '=' , 'purchase_items.product_id')
                    ->select('purchase_items.*' , 'products.name')
                    ->where('purchase_items.purchase_id' , request('record'))
                    ->limit($perPageRecord)
                    ->offset($pageRecordStart)
                    ->get();
        
    }
    protected static string $view = 'filament.resources.purchase-resource.pages.purchase-detail';
}
