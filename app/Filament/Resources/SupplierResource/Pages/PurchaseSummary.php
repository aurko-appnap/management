<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\SupplierResource;

class PurchaseSummary extends Page
{
    protected static string $resource = SupplierResource::class;
    public $purchaseSummary, $supplierId;
    
    public $totalPageCount;
    public $page;
    public function mount()
    {
        $this->supplierId = request('record');

        $perPageRecord = 5;
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $purchaseSummaryRecord = DB::table('purchases')
            ->select('*')
            ->where('supplier_id' , request('record'))
            ->get();

        $this->totalPageCount = (int)ceil(sizeof($purchaseSummaryRecord) / $perPageRecord);


        $this->purchaseSummary = DB::table('purchases')
                ->select('*')
                ->where('supplier_id' , request('record'))
                ->limit($perPageRecord)
                ->offset($pageRecordStart)
                ->get();

    }
    protected static string $view = 'filament.resources.supplier-resource.pages.purchase-summary';
}
