<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Illuminate\Http\Request;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CustomerResource;

class CustomerOrderSummary extends Page
{
    protected static string $resource = CustomerResource::class;
    public $customerOrderHistory;
    
    public function mount()
    {   

        $orderData = DB::table('orders')->select('customer_code' , 'order_number');

        $customerData = DB::table('customers')
                    ->joinSub($orderData , 'orderData' , function($join){
                        $join->on('customers.id' , '=' , 'orderData.customer_code');
                    })->get();
        
        dd($customerData);
        // $this->customerOrderHistory = DB::table('orders')
        //         // ->join('customers', 'customers.id' , '=' , 'orders.customer_code')
        //         // ->select('orders.*' , 'customers.id', 'customers.*')
        //         // ->groupBy('customers.id')
        //         ->select('*')
        //         ->groupBy('customer_code')
        //         ->get();

        // dd($this->customerOrderHistory);
    }
    protected static string $view = 'filament.resources.customer-resource.pages.customer-order-summary';
}
