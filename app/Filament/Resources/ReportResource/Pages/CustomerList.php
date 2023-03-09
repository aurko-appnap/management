<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerList extends Page
{
    protected static string $resource = ReportResource::class;
    protected static ?string $title = 'Detailed Customers Report';
    public $CustomerDetail;

    function mount()
    {
        $dates = explode(' - ', request('dateRange'));
        $customerId = request('customer');
        $allCustomer = request('all_customer');
        // dd($customerId);
        if($dates[0]!="" || $customerId || $allCustomer)
        {
            $query = DB::table('customers')
                ->join('orders' , 'orders.customer_code' , '=' , 'customers.id')
                ->join('order_items' , 'orders.id' , '=' , 'order_items.order_id')
                ->select(
                        // DB::raw('SUM(order_items.product_quantity) as total_product_quantity'),
                        'customers.name', 
                        'customers.id',
                        'orders.order_number',
                        'orders.order_placed_on',
                        'orders.total_price',
                        'orders.order_status',);
        
            if($dates[0] == "DD/MM/YYYY" || $dates[0] == "") 
            {
                $dates[1] = NULL;
            }
    
            if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
            {
                $query->whereDate('customers.created_at' , '>=' , Carbon::createFromFormat('d/m/Y', $dates[0]));
                $query->whereDate('customers.created_at' , '<=' , Carbon::createFromFormat('d/m/Y', $dates[1]));
            }
            
            if($allCustomer)
            {
                
            }
            else if($customerId != NULL)
                foreach($customerId as $id)
                {
                    $query->orWhere('customers.id', '=' , $id);
                }
            else
            {
    
            }
    
            $this->CustomerDetail = $query->get();
        }
        else
        {
            $this->CustomerDetail = [];
        }
    }
    protected static string $view = 'filament.resources.report-resource.pages.customer-list';
}
