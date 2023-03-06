<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerList extends Page
{
    protected static string $resource = ReportResource::class;
    public $CustomerDetail;

    function mount()
    {
        $dates = explode(' - ', request('dateRange'));
        $customerId = request('customer');
        $allCustomer = request('all_customer');

        if($dates[0]!="" || $customerId || $allCustomer)
        {
            $query = DB::table('customers')
                ->select('name' , 'id');
        
            if($dates[0] == "DD/MM/YYYY" || $dates[0] == "") 
            {
                $dates[1] = NULL;
            }
    
            if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
            {
                $query->whereDate('created_at' , '>=' , Carbon::createFromFormat('d/m/Y', $dates[0]));
                $query->whereDate('created_at' , '<=' , Carbon::createFromFormat('d/m/Y', $dates[1]));
            }
            
            if($allCustomer)
            {
                
            }
            else if($customerId > 0)
                $query->where('id' , $customerId);
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
