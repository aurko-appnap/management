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

    public $psTotalPageCount, $rsTotalPageCount, $pcTotalPageCount, $rcTotalPageCount;
    public $psPage, $rsPage, $pcPage, $rcPage;


    public function mount()
    {
        $psPerPageRecord = 5;
        $rsPerPageRecord = 5;
        $pcPerPageRecord = 5;
        $rcPerPageRecord = 5;

        request('psPage') == null ? $this->psPage = 1 : $this->psPage = request('psPage'); 
        request('rsPage') == null ? $this->rsPage = 1 : $this->rsPage = request('rsPage'); 
        request('pcPage') == null ? $this->pcPage = 1 : $this->pcPage = request('pcPage'); 
        request('rcPage') == null ? $this->rcPage = 1 : $this->rcPage = request('rcPage'); 
//----------------------------------------------------------------CUSTOMER DEBIT
    
        $psPageRecordStart = ($this->psPage-1)*$psPerPageRecord;
        $allCustomerDebitRecord = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'debit')
            ->get();
        
        $this->psTotalPageCount = (int)ceil(sizeof($allCustomerDebitRecord) / $psPerPageRecord);



        $this->allCustomerDebit = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'debit')
            ->limit($psPerPageRecord)
            ->offset($psPageRecordStart)
            ->get();
        
        foreach($this->allCustomerDebit as $key => $sale)
            {
                $this->toalCustomerDebit = $this->toalCustomerDebit + $sale->transaction_amount;
                $this->allPaymentByCustomer[] = (float)$sale->transaction_amount;
            }

//----------------------------------------------------------------CUSTOMER CREDIT
        $rsPageRecordStart = ($this->rsPage-1)*$rsPerPageRecord;
        $allCustomerCreditRecord = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'credit')
            ->get();
        
        $this->rsTotalPageCount = (int)ceil(sizeof($allCustomerCreditRecord) / $rsPerPageRecord);

        $this->allCustomerCredit = DB::table('transactions')
            ->join('customers' , 'customers.id' , '=' , 'transactions.entity_id')
            ->join('orders' , 'orders.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'customers.name', 'orders.order_number')
            ->where('transactions.entity_type' , 'customer')
            ->where('transactions.transaction_type', 'credit')
            ->limit($rsPerPageRecord)
            ->offset($rsPageRecordStart)
            ->get();

        foreach($this->allCustomerCredit as $key => $refund)
            {
                $this->toalCustomerCredit = $this->toalCustomerCredit + $refund->transaction_amount;
            }    

//----------------------------------------------------------------SUPPLIER CREDIT
        $pcPageRecordStart = ($this->pcPage-1)*$pcPerPageRecord;
        $allSupplierCreditRecord = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'credit')
            ->get();
            
            $this->pcTotalPageCount = (int)ceil(sizeof($allSupplierCreditRecord) / $pcPerPageRecord);

        $this->allSupplierCredit = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'credit')
            ->limit($pcPerPageRecord)
            ->offset($pcPageRecordStart)
            ->get();

        foreach($this->allSupplierCredit as $key => $refund)
            {
                $this->totalSupplierCredit = $this->totalSupplierCredit + $refund->transaction_amount;
                $this->allPaymentToSupplier[] = (float)$refund->transaction_amount;
            }

//----------------------------------------------------------------SUPPLIER DEBIT
        $rcPageRecordStart = ($this->rcPage-1)*$rcPerPageRecord;
        $allSupplierDebitRecord = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'debit')
            ->get();
        $this->rcTotalPageCount = (int)ceil(sizeof($allSupplierDebitRecord) / $rcPerPageRecord);


        $this->allSupplierDebit = DB::table('transactions')
            ->join('suppliers' , 'suppliers.id' , '=' , 'transactions.entity_id')
            ->join('purchases' , 'purchases.id' , '=' , 'transactions.trading_id')
            ->select('transactions.*' , 'suppliers.name', 'purchases.purchase_number')
            ->where('transactions.entity_type' , 'supplier')
            ->where('transactions.transaction_type', 'debit')
            ->limit($rcPerPageRecord)
            ->offset($rcPageRecordStart)
            ->get();

        foreach($this->allSupplierDebit as $key => $refund)
            {
                $this->totalSupplierDebit = $this->totalSupplierDebit + $refund->transaction_amount;
            }
    }

    protected static string $view = 'filament.resources.report-resource.pages.sales-report';
}
