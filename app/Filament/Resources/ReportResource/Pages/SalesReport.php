<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Table;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use Filament\Tables\Columns\TextColumn;
use App\Filament\Resources\ReportResource;
use Filament\Tables\Concerns\InteractsWithTable;

class SalesReport extends Page
{   
    protected static string $resource = ReportResource::class;

    public $allCustomerDebit, $allCustomerCredit;
    public $allSupplierCredit , $allSupplierDebit;

    public $toalCustomerCredit=0, $toalCustomerDebit=0;
    public $totalSupplierCredit=0, $totalSupplierDebit=0;

    public $allPaymentByCustomer, $allPaymentToSupplier;

    public function mount()
    {
//----------------------------------------------------------------CUSTOMER DEBIT
        $this->allCustomerDebit = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'debit')
            ->get();
        
        foreach($this->allCustomerDebit as $key => $sale)
            {
                $this->toalCustomerDebit = $this->toalCustomerDebit + $sale->transaction_amount;
                $this->allPaymentByCustomer[] = (float)$sale->transaction_amount;
            }

//----------------------------------------------------------------CUSTOMER CREDIT

        $this->allCustomerCredit = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'credit')
            ->get();

        foreach($this->allCustomerCredit as $key => $refund)
            {
                $this->toalCustomerCredit = $this->toalCustomerCredit + $refund->transaction_amount;
            }    

//----------------------------------------------------------------SUPPLIER CREDIT

        $this->allSupplierCredit = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'credit')
            ->get();

        foreach($this->allSupplierCredit as $key => $refund)
            {
                $this->totalSupplierCredit = $this->totalSupplierCredit + $refund->transaction_amount;
                $this->allPaymentToSupplier[] = (float)$refund->transaction_amount;
            }

//----------------------------------------------------------------SUPPLIER DEBIT

        $this->allSupplierDebit = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'debit')
            ->get();

        foreach($this->allSupplierDebit as $key => $refund)
            {
                $this->totalSupplierDebit = $this->totalSupplierDebit + $refund->transaction_amount;
            }
    }

    protected static string $view = 'filament.resources.report-resource.pages.sales-report';
}
