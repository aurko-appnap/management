<?php

namespace App\Filament\Resources\SupplierResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\SupplierResource;

class PurchaseSummary extends Page
{
    protected static string $resource = SupplierResource::class;
    public $purchaseSummary;
    public function mount()
    {
        $this->purchaseSummary = DB::table('purchases')
                ->select('*')
                ->where('supplier_id' , request('record'))
                ->get();

        // dd(request('record'));
    }
    protected static string $view = 'filament.resources.supplier-resource.pages.purchase-summary';
}
