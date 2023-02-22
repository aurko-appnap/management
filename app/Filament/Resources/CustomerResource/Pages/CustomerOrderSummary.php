<?php

namespace App\Filament\Resources\CustomerResource\Pages;

use Illuminate\Http\Request;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\CustomerResource;

class CustomerOrderSummary extends Page
{
    protected static string $resource = CustomerResource::class;
    public $customerOrderSummary;
    
    public function mount()
    {   
        $this->customerOrderSummary = DB::table('orders')
                ->select('*')
                ->where('customer_code' , request('record'))
                ->get();
    }
    protected static string $view = 'filament.resources.customer-resource.pages.customer-order-summary';
}
