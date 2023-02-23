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
if(count($popularProductList)>0) $noDataDisplay1 = 'none';
else $noDataDisplay1 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay1}}">No Data Available!</div>


<!-- --------------------------------------------------------------- -->
<table>
    <caption>Zero Selling Products</caption>
    <thead>
        <th>Serial</th>
        <th>Product Name</th>
        <th>Product Price</th>
    </thead>
    <tbody>
        @foreach ($zeroSellingProducts as $key => $product)
        <tr>
            <td>{{$key+1}}</td>
            <td>{{$product->name}}</td>
            <td>৳ {{number_format($product->price , 2)}}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<?php
if(count($popularProductList)>0) $noDataDisplay2 = 'none';
else $noDataDisplay2 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay2}}">No Data Available!</div>
    
</x-filament::page>
