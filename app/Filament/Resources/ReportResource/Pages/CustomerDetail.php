<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class CustomerDetail extends Page
{
    protected static string $resource = ReportResource::class;
    public $name;
    public $email;
    public $phone;
    public $registered_on;
    function mount()
    {
        if(request('customer'))
        {
            $temp = DB::table('customers')
                    ->select('*')
                    ->where('id' , request('customer'))
                    ->first();
            if($temp)
            {
                $this->name = $temp?->name;
                $this->email = $temp?->email;
                $this->phone = $temp?->phone;
                $this->registered_on = $temp?->created_at;
            }
        }
        else
        {
            
        }
            

    }
    protected static string $view = 'filament.resources.report-resource.pages.customer-detail';
}
