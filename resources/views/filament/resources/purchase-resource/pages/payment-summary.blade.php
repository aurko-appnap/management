<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="{{asset('css/pagination.css')}}">

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Payment Made for this Purchase</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell p-2">Payment Amount</td>
                <td class="filament-tables-header-cell p-2">Payment Method</th>
                <td class="filament-tables-header-cell p-2">Payment Time</td>
                <td class="filament-tables-header-cell p-2">Payment Message</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($paymentSummary as $key => $payment)
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">৳ {{number_format($payment->transaction_amount , 2)}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">{{$payment->transaction_method}}</td>
                    <td class="filament-tables-cell dark:text-white">{{date("d/m/Y h:i:s A", strtotime($payment->created_at))}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">{{$payment->transaction_message}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<?php
if(count($paymentSummary)>0) $noDataDisplay1 = 'none';
else $noDataDisplay1 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay1}}">No Data Available!</div>

<br><br>
<!-- --------------------------------------------------------------- -->


<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Refund Made on this Order</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell p-2">Payment Amount</td>
                <td class="filament-tables-header-cell p-2">Payment Method</td>
                <td class="filament-tables-header-cell p-2">Payment Time</td>
                <td class="filament-tables-header-cell p-2">Payment Message</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($refundSummary as $key => $payment)
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">৳ {{number_format($payment->transaction_amount , 2)}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">{{$payment->transaction_method}}</td>
                    <td class="filament-tables-cell dark:text-white">{{date("d/m/Y h:i:s A", strtotime($payment->created_at))}}</td>
                    <td class="filament-tables-cell dark:text-white px-4">{{$payment->transaction_message}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<?php
if(count($refundSummary)>0) $noDataDisplay2 = 'none';
else $noDataDisplay2 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay2}}">No Data Available!</div>
        
</x-filament::page>
