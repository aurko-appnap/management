<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerSummary extends Page
{
    protected static string $resource = ReportResource::class;
    protected static ?string $title = 'Customers Summary Report';

    public $CustomerSummary;
    
    public $page;
    public $totalPageCount;
    public $perPageRecord = 2;
    function mount()
    {
        $dates = explode(' - ', request('dateRange'));
        $saleType = request('sale');
        $amountComparison = request('spent');
        $amount = request('amount');
        $productId = request('product_item');
        $categorytId = request('category_item');
        $customerId = request('customer_item');
        request('page') == null ? $this->page = 1 : $this->page = request('page'); 
        $pageRecordStart = ($this->page-1)*$this->perPageRecord;
        // dd($productId[0]);
        if(($dates[0] != "DD/MM/YYYY" && $dates[0] != "") || $saleType!=NULL || ($amountComparison > 0) || $productId || $categorytId || $customerId)
        {
            $query = DB::table('orders')
                ->join('customers' ,    'customers.id' ,            '=' , 'orders.customer_code');
                

                if($productId!=NULL || $categorytId!=NULL)
                {
                    $query->join('order_items' ,    'orders.id' ,            '=' , 'order_items.order_id')
                        ->join('products' , 'products.id' , '=' , 'order_items.product_id');
                }
                
                $query->select(
                    DB::raw(
                        'COUNT(orders.id) as order_count, SUM(orders.total_price) as total_order_price'),
                        'orders.order_number', 
                        'customers.name' , 
                        'customers.id' , 
                        'customers.email', 
                        'customers.phone')
                ->groupBy('orders.customer_code')
                ->orderBy('order_count' , 'desc');

            if($dates[0] == "DD/MM/YYYY" || $dates[0] == "") 
            {
                $dates[1] = NULL;
            }

            if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
            {
                $query->whereDate('orders.order_placed_on' , '>=' , Carbon::createFromFormat('d/m/Y', $dates[0]));
                $query->whereDate('orders.order_placed_on' , '<=' , Carbon::createFromFormat('d/m/Y', $dates[1]));
            }

            if($saleType != NULL)
            {
                $query->where('orders.order_status', '=' , $saleType);
            }

            if($amountComparison>0)
            {
                if($amountComparison == 1)
                    $query->where('orders.total_price' , '>' , $amount);
                else if($amountComparison == 2)
                    $query->where('orders.total_price' , '<' , $amount);
                else
                    $query->where('orders.total_price' , '=' , $amount);
            }
            if($productId != NULL)
            {
                foreach($productId as $id)
                {
                    $query->orWhere('products.id' , '=' , $id);
                }
            }

            if($categorytId != NULL)
            {
                foreach($categorytId as $id)
                {
                    $query->orWhere('products.category_id' , '=' , $id);
                }
            }

            if($customerId != NULL)
            {
                foreach($customerId as $id)
                {
                    $query->orWhere('customers.id' , '=' , $id);
                }
            }

            $this->CustomerSummary = $query->get();
            // dd($this->CustomerSummary);
        }
        else
        {
            $this->CustomerSummary = [];
        }
        
        
    }
    protected static string $view = 'filament.resources.report-resource.pages.customer-summary';
}
