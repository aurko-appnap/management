<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Order Detail</caption>
    <thead>
        <th>Serial</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Unit Price</th>
        <th>Total Price</th>
    </thead>
    <tbody>
        @foreach ($OrderDetailSummary as $key => $order)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->product_quantity}}</td>
            <td>৳ {{number_format($order->price, 2)}}</td>
            <td>৳ {{number_format($order->total_price, 2)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($OrderDetailSummary)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}};">No Data Available!</div>


</x-filament::page>
