<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Purchase Summary</caption>
    <thead>
        <th>Serial</th>
        <th>Purchase Number</th>
        <th>Purchase Date</th>
        <th>Purchase Price</th>
        <th>Purchase Status</th>
        <th>Purchase Detail</th>
    </thead>
    <tbody>
        @foreach ($purchaseSummary as $key => $purchase)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$purchase->purchase_number}}</td>
            <td>{{$purchase->created_at}}</td>
            <td>৳ {{$purchase->total_purchased_price}}</td>
            <td>{{$purchase->purchase_status}}</td>
            <td><a href="{{url('/admin/purchases/purchase-detail/'.$purchase->id)}}">View</a></td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($purchaseSummary)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}}">No Data Available!</div>
    
</x-filament::page>
