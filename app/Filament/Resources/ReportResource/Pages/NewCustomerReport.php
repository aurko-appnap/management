<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class NewCustomerReport extends Page
{
    protected static string $resource = ReportResource::class;
    protected static ?string $title = 'New Customers Report';
    public $CustomerDetail;
    public $customerCount;

    function mount()
    {
        $dates = explode(' - ', request('dateRange'));
        if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
        {
            $this->CustomerDetail = DB::table('customers')
                ->whereDate('created_at' , '>=' , Carbon::createFromFormat('d/m/Y', $dates[0]))
                ->whereDate('created_at' , '<=' , Carbon::createFromFormat('d/m/Y', $dates[1]))
                ->orderBy('id' , 'DESC')
                ->get();
        }
        else
        {
            $this->CustomerDetail = [];
        }
        $this->customerCount = sizeof($this->CustomerDetail);
        // dd($dates);
    }

    protected static string $view = 'filament.resources.report-resource.pages.new-customer-report';
}
