<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Purchase Detail</caption>
    <thead>
        <th>Serial</th>
        <th>Product Name</th>
        <th>Quantity</th>
        <th>Purchase Price</th>
    </thead>
    <tbody>
        @foreach ($purchaseDetail as $key => $purchase)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$purchase->name}}</td>
            <td>{{$purchase->product_quantity}}</td>
            <td>৳ {{$purchase->product_total_price}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($purchaseDetail)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}}">No Data Available!</div>
</x-filament::page>
