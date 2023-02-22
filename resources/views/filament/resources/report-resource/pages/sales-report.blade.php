<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<x-filament::page>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

<div class="grid-container">
    <canvas class="grid_item" id="statChart" style="width:100%;max-width:500px"></canvas>
    <canvas class="grid_item" id="supplierPaymentChart" style="width:100%;max-width:500px"></canvas>
</div>

<div id="target">

<!-- SUPPLIER CREDIT || PURCHASE FROM SUPPLIERS-->
<table>
    <caption>Payments to Suppliers</caption>
    <thead>
        <th>Serial</th>
        <th>Purchase Number</th>
        <th>Supplier Name</th>
        <th>Purchase Amount</th>
        <th>Purchase Message</th>
        <th>Transaction Method</th>
        <th>Purchase Time</th>
    </thead>
    <tbody>
        <?php $counter = 0 ?>
        @foreach ($allSupplierCredit as $key => $purchase)
        <?php $counter++; ?>
        <tr>
            <td>{{$counter}}</td>
            <td>{{$purchase->purchase_number}}</td>
            <td>{{$purchase->name}}</td>
            <td>৳ {{$purchase->transaction_amount}}</td>
            <td>{{$purchase->transaction_message}}</td>
            <td>{{$purchase->transaction_method}}</td>
            <td>{{$purchase->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$totalSupplierCredit}}
</div>
<br>
<!-- SUPPLIER DEBIT || REFUND FROM SUPPLIERS-->
<table>
    <caption>Refunds from Suppliers</caption>
    <thead>
        <th>Serial</th>
        <th>Purchase Number</th>
        <th>Supplier Name</th>
        <th>Refund Amount</th>
        <th>Refund Time</th>
    </thead>
    <tbody>
        <?php $counter = 0 ?>
        @foreach ($allSupplierDebit as $key => $purchase)
        <?php $counter++; ?>
        <tr>
            <td>{{$counter}}</td>
            <td>{{$purchase->purchase_number}}</td>
            <td>{{$purchase->name}}</td>
            <td>৳ {{$purchase->transaction_amount}}</td>
            <td>{{$purchase->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="summary_section">
    Total Refund from Suppliers:  ৳ {{$totalSupplierDebit}}
</div>

<div class="html2pdf__page-break"></div>
<br>
<!-- CUSTOMER DEBIT || PAYMENT FROM CUSTOMERS-->
<table>
    <caption>Payments from Customers</caption>
    <thead>
        <th>Serial</th>
        <th>Order Number</th>
        <th>Order Of</th>
        <th>Transaction Amount</th>
        <th>Transaction Message</th>
        <th>Transaction Method</th>
        <th>Transaction Time</th>
    </thead>
    <tbody>
        <?php $counter = 0 ?>
        @foreach ($allCustomerDebit as $key => $sale)
        <?php $counter++; ?>
        <tr>
            <td>{{$counter}}</td>
            <td>{{$sale->order_number}}</td>
            <td>{{$sale->name}}</td>
            <td>৳ {{$sale->transaction_amount}}</td>
            <td>{{$sale->transaction_message}}</td>
            <td>{{$sale->transaction_method}}</td>
            <td>{{$sale->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$toalCustomerDebit}}
</div>
<br>
<!-- SUPPLIER CREDIT || REFUND TO CUSTOMERS-->
<table>
    <caption>Refunds to Customers</caption>
    <thead>
        <th>Serial</th>
        <th>Order Number</th>
        <th>Refund to</th>
        <th>Refund Amount</th>
        <th>Refund Method</th>
        <th>Refund Time</th>
    </thead>
    <tbody>
        <?php $counter = 0 ?>
        @foreach ($allCustomerCredit as $key => $sale)
        <?php $counter++; ?>
        <tr>
            <td>{{$counter}}</td>
            <td>{{$sale->order_number}}</td>
            <td>{{$sale->name}}</td>
            <td>৳ {{$sale->transaction_amount}}</td>
            <td>{{$sale->transaction_method}}</td>
            <td>{{$sale->created_at}}</td>
        </tr>
        @endforeach
    </tbody>
</table>
<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$toalCustomerCredit}}
</div>

<hr>
<br><br>
<!-- SALES SUMMARY-->
<table>
    <thead>
        <th colspan="4">SALES SUMMARY TABLE</th>
    </thead>
    <tbody>
        <tr>
            <td colspan="2"><b>SUPPLIER</b></td>
            <td colspan="2"><b>CUSTOMER</b></td>
        </tr>
        <tr>
            <td>Paid</td>
            <td>৳ {{$totalSupplierCredit}}</td>
            <td>Received</td>
            <td>৳ {{$toalCustomerDebit}}</td>
        </tr>
        <tr>
            <td>Refund</td>
            <td>৳ {{$totalSupplierDebit}}</td>
            <td>Refund</td>
            <td>৳ {{$toalCustomerCredit}}</td>
        </tr>
    </tbody>
</table>

</div>
<button class="btn" onclick="downLoadSales()">Download</button>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.8.0/html2pdf.bundle.min.js" integrity="sha512-w3u9q/DeneCSwUDjhiMNibTRh/1i/gScBVp2imNVAMCt6cUHIw6xzhzcPFIaL3Q1EbI2l+nu17q2aLJJLo4ZYg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
   
   function downLoadSales(){
        var element = document.getElementById("target");
        html2pdf(element, {
            margin:       [10 , 15 , 0 , 15],
            filename:     'sales_report.pdf',
            html2canvas:  { scale: 2, dpi: 300, backgroundColor: null},
            jsPDF:        { unit: 'mm', format: 'a4', orientation: 'landscape' },
            pagebreak: { after: ['#after1'], avoid: 'img' }
        });
   } 
   

    var xValues = [1,2,3,4,5,6,7,8,9,10];
    var customerPaymentValues = @json(array_reverse($allPaymentByCustomer));
    var supplierPaymentValues = @json(array_reverse($allPaymentToSupplier));
    
    new Chart("supplierPaymentChart", {
      type: "bar",
      label: "A",
      data: {
        labels: xValues,
        datasets: [{
          fill: false,
          lineTension: 0.5,
          backgroundColor: [
            'rgba(255, 99, 132, .5)',
            'rgba(255, 159, 64, .5)',
            'rgba(255, 205, 86, .5)',
            'rgba(75, 192, 192, .5)',
            'rgba(54, 162, 235, .5)',
            'rgba(153, 102, 255, .5)',
            'rgba(3, 252, 73, .5)',
            'rgba(3, 119, 252, .5)',
            'rgba(252, 165, 3, .5)',
            'rgba(252, 3, 111, .5)',
            ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 205, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(3, 252, 73, 1)',
            'rgba(3, 119, 252, 1)',
            'rgba(252, 165, 3, 1)',
            'rgba(252, 3, 111, 1)',
            ],
            borderWidth: 1.5,
          data: supplierPaymentValues
        }]
      },
      options: {
        title: {
            display: true,
            text: "Latest Payments To Suppliers",
            fontSize: 16
        },
        legend: {display: false},
        scales: {
          yAxes: [{ticks: {min: 6}}],
          xAxes: [{ticks: {max: 10}}],
        },
      }
    });
    
    new Chart("statChart", {
      type: "bar",
      label: "A",
      data: {
        labels: xValues,
        datasets: [{
          fill: false,
          lineTension: 0.5,
          backgroundColor: [
            'rgba(255, 99, 132, .5)',
            'rgba(255, 159, 64, .5)',
            'rgba(255, 205, 86, .5)',
            'rgba(75, 192, 192, .5)',
            'rgba(54, 162, 235, .5)',
            'rgba(153, 102, 255, .5)',
            'rgba(3, 252, 73, .5)',
            'rgba(3, 119, 252, .5)',
            'rgba(252, 165, 3, .5)',
            'rgba(252, 3, 111, .5)',
            ],
          borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(255, 159, 64, 1)',
            'rgba(255, 205, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(3, 252, 73, 1)',
            'rgba(3, 119, 252, 1)',
            'rgba(252, 165, 3, 1)',
            'rgba(252, 3, 111, 1)',
            ],
            borderWidth: 1.5,
          data: customerPaymentValues
        }]
      },
      options: {
        title: {
            display: true,
            text: "Latest Payments From Customers",
            fontSize: 16
        },
        legend: {display: false},
        scales: {
          yAxes: [{ticks: {min: 6}}],
          xAxes: [{ticks: {max: 10}}],
        },
      }
    });
    
    </script>
</x-filament::page>
