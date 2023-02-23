<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Category wise order summary</caption>
    <thead>
        <th>Serial</th>
        <th>Order Number</th>
        <th>Order By</th>
        <th>Order Date</th>
        <th>Shipping Address</th>
        <th>Shipping Method</th>
        <th>Order Price</th>
        <th>Order Status</th>
        <th>Order Detail</th>
    </thead>
    <tbody>
        @foreach ($OrderSummary as $key => $order)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$order->order_number}}</td>
            <td>{{$order->name}}</td>
            <td>{{$order->order_placed_on}}</td>
            <td>{{$order->shipping_address}}</td>
            <td>{{$order->shipping_method}}</td>
            <td>৳ {{$order->total_price}}</td>
            <td>{{$order->order_status}}</td>
            <td><a href="{{url('/admin/orders/order-detail/'.$order->id)}}">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($OrderSummary)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}};">No Data Available!</div>
</x-filament::page>
