<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Illuminate\Http\Request;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CustomerResource;

class CustomerOrderSummary extends Page
{
    protected static string $resource = CustomerResource::class;
    public $customerOrderSummary, $customerID;
    
    public $totalPageCount;
    public $page;
    public function mount()
    {   $this->customerID = request('record');

        $perPageRecord = 5;
        request('p') == null ? $this->page = 1 : $this->page = request('p'); 
        $pageRecordStart = ($this->page-1)*$perPageRecord;
        $customerOrderSummaryRecord = DB::table('orders')
                ->select('*')
                ->where('customer_code' , request('record'))
                ->get();
            $this->totalPageCount = (int)ceil(sizeof($customerOrderSummaryRecord) / $perPageRecord);


        $this->customerOrderSummary = DB::table('orders')
                ->select('*')
                ->where('customer_code' , request('record'))
                ->limit($perPageRecord)
                ->offset($pageRecordStart)
                ->get();
    }
    protected static string $view = 'filament.resources.customer-resource.pages.customer-order-summary';
}
