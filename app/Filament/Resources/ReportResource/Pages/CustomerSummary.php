<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerSummary extends Page
{
    protected static string $resource = ReportResource::class;
    
    function mount()
    {
        $query = DB::table('customers')
            ->join('orders' , 'orders.customer_code' , '=' , 'customers.id')
            ->select('customers.name' , 'orders.order_number');

        $dates = explode(' - ', request('dateRange'));
        $saleType = request('sale');
        $amountComparison = request('spent');
        $amount = request('amount');

        if($saleType)
            $query->where('orders.order_status' , $saleType);

        if($amountComparison>0)
        {
            if($amountComparison == 1)
                $query->where('orders.total_price' , '>' , $amount);
            else if($amountComparison == 2)
                $query->where('orders.total_price' , '<' , $amount);
            else
                $query->where('orders.total_price' , '=' , $amount);
        }
        
        // dd($query->get());
    }
    protected static string $view = 'filament.resources.report-resource.pages.customer-summary';
}
