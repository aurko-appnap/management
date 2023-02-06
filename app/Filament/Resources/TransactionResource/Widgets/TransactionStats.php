<?php

namespace App\Filament\Resources\TransactionResource\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class TransactionStats extends BaseWidget
{
    protected function getCards(): array
    {
        $supplier_credit = DB::table('transactions')
                        ->selectRaw('sum(transaction_amount) as amount')
                        ->where('entity_type' , '=' , 'supplier')
                        ->where('transaction_type' , '=' , 'credit')
                        ->first();

        $supplier_debit = DB::table('transactions')
                        ->selectRaw('sum(transaction_amount) as amount')
                        ->where('entity_type' , '=' , 'supplier')
                        ->where('transaction_type' , '=' , 'debit')
                        ->first();

        $supplier_balance = $supplier_credit->amount - $supplier_debit->amount;

        $customer_credit = DB::table('transactions')
                        ->selectRaw('sum(transaction_amount) as amount')
                        ->where('entity_type' , '=' , 'customer')
                        ->where('transaction_type' , '=' , 'credit')
                        ->first();

        $customer_debit = DB::table('transactions')
                        ->selectRaw('sum(transaction_amount) as amount')
                        ->where('entity_type' , '=' , 'customer')
                        ->where('transaction_type' , '=' , 'debit')
                        ->first();

        $selling_balance = $customer_debit->amount - $customer_credit->amount;
        $inventory_valuation = $supplier_balance - $selling_balance;

        $due = DB::table('orders')
                ->selectRaw('sum(total_price) as total')
                ->where('order_status' , '=' , 0)
                ->first();

        $payable = DB::table('purchases')
                ->selectRaw('sum(total_purchased_price) as total')
                ->where('purchase_status' , '=' , 0)
                ->first();

        return [
            Card::make('Total Purchase from Supplier', '৳ '.$supplier_balance),
            Card::make('Total Sell to Customer', '৳ '.$selling_balance),
            Card::make('Current Inventory Valuation', '৳ '.$inventory_valuation),
            Card::make('Due from Customers', '৳ '.$due->total),
            Card::make('Payable to Suppliers', '৳ '.$payable->total),
        ];
    }
}
