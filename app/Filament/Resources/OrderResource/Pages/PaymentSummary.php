<?php

namespace App\Filament\Resources\OrderResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\OrderResource;

class PaymentSummary extends Page
{
    protected static string $resource = OrderResource::class;
    public $paymentSummary, $refundSummary;
    public function mount()
    {
        $this->paymentSummary = DB::table('transactions')
                    ->select('*')
                    ->where('trading_id' , request('record'))
                    ->where('trading_type' , 'order')
                    ->where('entity_type' , 'customer')
                    ->where('transaction_type' , 'debit')
                    ->get();

        $this->refundSummary = DB::table('transactions')
                    ->select('*')
                    ->where('trading_id' , request('record'))
                    ->where('trading_type' , 'order')
                    ->where('entity_type' , 'customer')
                    ->where('transaction_type' , 'credit')
                    ->get();
    
        // dd($this->paymentSummary);
    }

    
    protected static string $view = 'filament.resources.order-resource.pages.payment-summary';
}
