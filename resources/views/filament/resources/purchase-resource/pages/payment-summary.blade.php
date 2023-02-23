<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Payment Made for this Purchase</caption>
    <thead>
        <th>Serial</th>
        <th>Payment Amount</th>
        <th>Payment Method</th>
        <th>Payment Time</th>
        <th>Payment Message</th>
    </thead>
    <tbody>
        @foreach ($paymentSummary as $key => $payment)
        <tr>
            <td>{{$key+1}}</td>
            <td>৳ {{number_format($payment->transaction_amount , 2)}}</td>
            <td>{{$payment->transaction_method}}</td>
            <td>{{date("d/m/Y h:i:s A", strtotime($payment->created_at))}}</td>
            <td>{{$payment->transaction_message}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($paymentSummary)>0) $noDataDisplay1 = 'none';
else $noDataDisplay1 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay1}}">No Data Available!</div>

<br><br>
<!-- --------------------------------------------------------------- -->
<table>
    <caption>Refund Made on this Purchase</caption>
    <thead>
        <th>Serial</th>
        <th>Payment Amount</th>
        <th>Payment Method</th>
        <th>Payment Time</th>
        <th>Payment Message</th>
    </thead>
    <tbody>
        @foreach ($refundSummary as $key => $payment)
        <tr>
            <td>{{$key+1}}</td>
            <td>৳ {{number_format($payment->transaction_amount , 2)}}</td>
            <td>{{$payment->transaction_method}}</td>
            <td>{{date("d/m/Y h:i:s A", strtotime($payment->created_at))}}</td>
            <td>{{$payment->transaction_message}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($refundSummary)>0) $noDataDisplay2 = 'none';
else $noDataDisplay2 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay2}}">No Data Available!</div>
        
</x-filament::page>
