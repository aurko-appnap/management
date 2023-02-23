<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">

<table>
    <caption>Top Selling Products</caption>
    <thead>
        <th>Serial</th>
        <th>Product Name</th>
        <th>Product Price</th>
        <th>Number of Product Sold</th>
    </thead>
    <tbody>
        @foreach ($popularProductList as $key => $product)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$product->name}}</td>
            <td>৳ {{number_format($product->price , 2)}}</td>
            <td>{{$product->p_quantity}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($popularProductList)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}}">No Data Available!</div>
    
</x-filament::page>
