<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerSummary extends Page
{
    protected static string $resource = ReportResource::class;
    public $CustomerSummary;
    
    public $page;
    public $totalPageCount;
    public $perPageRecord = 2;
    function mount()
    {
        $query = DB::table('customers')
            ->join('orders' , 'orders.customer_code' , '=' , 'customers.id')
            ->select(DB::raw('count(orders.order_number) as order_count') , 'customers.name' , 'customers.id')
            ->groupBy('customers.name')
            ->orderBy('order_count' , 'desc');

        $dates = explode(' - ', request('dateRange'));
        $saleType = request('sale');
        $amountComparison = request('spent');
        $amount = request('amount');
        request('page') == null ? $this->page = 1 : $this->page = request('page'); 
        $pageRecordStart = ($this->page-1)*$this->perPageRecord;

        if($dates[0] == "DD/MM/YYYY" || $dates[0] == "") 
            $dates[1] = NULL;

        if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
            {
                $query->whereDate('orders.order_placed_on' , '>=' , Carbon::createFromFormat('d/m/Y', $dates[0]));
                $query->whereDate('orders.order_placed_on' , '<=' , Carbon::createFromFormat('d/m/Y', $dates[1]));
            }

        if($saleType != NULL)
                $query->where('orders.order_status', '=' , $saleType);

        if($amountComparison>0)
        {
            if($amountComparison == 1)
                $query->where('orders.total_price' , '>' , $amount);
            else if($amountComparison == 2)
                $query->where('orders.total_price' , '<' , $amount);
            else
                $query->where('orders.total_price' , '=' , $amount);
        }

        // dd($dates);
        // dd($query->get());
        // $this->totalPageCount = (int)ceil(sizeof($query->get()) / $this->perPageRecord);

        // $query->limit($this->perPageRecord)
        //     ->offset($pageRecordStart);

        $this->CustomerSummary = $query->get();
        
        
    }
    protected static string $view = 'filament.resources.report-resource.pages.customer-summary';
}
