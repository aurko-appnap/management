<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Carbon\CarbonPeriod;
use Illuminate\Support\Carbon;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;
use App\Models\Customer;

class NewCustomerReport extends Page
{
    protected static string $resource = ReportResource::class;
    protected static ?string $title = 'New Customers Report';
    public $totalRegisteredCustomer = 0;
    public $filterDates;
    public $registrationData;
    public $resultCount = 0;

    function mount()
    {
        $dates = explode(' - ', request('dateRange'));
        if($dates[0] != "DD/MM/YYYY" && $dates[0] != "")
            {
                $fromDateTemp = Carbon::parse(Carbon::createFromFormat('d/m/Y', $dates[0]));
                $toDateTemp = Carbon::parse(Carbon::createFromFormat('d/m/Y', $dates[1]));
                $period = CarbonPeriod::create($fromDateTemp, $toDateTemp);

                foreach ($period as $date) {
                    $this->filterDates[] =  $date->format('d/m/Y');
                    $temp = Customer::whereDate('created_at', '=' , $date->format('Y-m-d'))->count();
                    $this->registrationData[] = $temp;
                    $this->totalRegisteredCustomer = $this->totalRegisteredCustomer + $temp;
                    $this->resultCount++;
                }
            }
    }

    protected static string $view = 'filament.resources.report-resource.pages.new-customer-report';
}
