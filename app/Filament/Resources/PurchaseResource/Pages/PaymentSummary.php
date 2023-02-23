<?php

namespace App\Filament\Resources\PurchaseResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\PurchaseResource;

class PaymentSummary extends Page
{
    protected static string $resource = PurchaseResource::class;
    public $paymentSummary, $refundSummary;
    public function mount()
    {
        $this->paymentSummary = DB::table('transactions')
                    ->select('*')
                    ->where('trading_id' , request('record'))
                    ->where('trading_type' , 'purchase')
                    ->where('entity_type' , 'supplier')
                    ->where('transaction_type' , 'credit')
                    ->get();

        $this->refundSummary = DB::table('transactions')
                    ->select('*')
                    ->where('trading_id' , request('record'))
                    ->where('trading_type' , 'purchase')
                    ->where('entity_type' , 'supplier')
                    ->where('transaction_type' , 'debit')
                    ->get();
    
    }
    protected static string $view = 'filament.resources.purchase-resource.pages.payment-summary';
}
