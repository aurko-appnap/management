<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js"></script>
<x-filament::page>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link rel="stylesheet" href="{{asset('css/pagination.css')}}">

<div class="grid-container">
    <canvas class="grid_item" id="statChart" style="width:100%;max-width:500px"></canvas>
    <canvas class="grid_item" id="supplierPaymentChart" style="width:100%;max-width:500px"></canvas>
</div>

<div id="target">

<!-- SUPPLIER CREDIT || PURCHASE FROM SUPPLIERS-->

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Payments to Suppliers</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-2 px-4">Serial</td>
                <td class="filament-tables-header-cell w-2 p-2">Purchase Number</td>
                <td class="filament-tables-header-cell w-2 p-2">Supplier Name</td>
                <td class="filament-tables-header-cell w-2 p-2">Purchase Amount</th>
                <td class="filament-tables-header-cell w-2 p-2">Purchase Message</th>
                <td class="filament-tables-header-cell w-2 p-2">Transaction Method</td>
                <td class="filament-tables-header-cell w-2 p-2">Purchase Time</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                <?php $counter = 0 ?>
                @foreach ($allSupplierCredit as $key => $purchase)
                <?php $counter++; ?>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$counter}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->purchase_number}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$purchase->transaction_amount}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->transaction_message}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->transaction_method}}</td>
                    <td class="filament-tables-cell dark:text-white">{{date("d/m/Y h:i:s A", strtotime($purchase->created_at))}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
        <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
            <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                <div class="flex items-center">
                    <div class="pl-2 text-sm font-medium dark:text-white"></div>
                </div>
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">                          
                        @for($currentPage = 1 ; $currentPage <= $psTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/sales-report?psPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $psPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
                                    >
                                        <span>{{$currentPage}}</span>
                                    </button>
                                </a>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>
            </div>
        </nav>
    </div>
</div>

<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$totalSupplierCredit}}
</div>
<br>
<!-- SUPPLIER DEBIT || REFUND FROM SUPPLIERS-->
<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Refunds from Suppliers</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-2 px-4">Serial</td>
                <td class="filament-tables-header-cell w-2 p-2">Purchase Number</td>
                <td class="filament-tables-header-cell w-2 p-2">Supplier Name</td>
                <td class="filament-tables-header-cell w-2 p-2">Refund Amount</td>
                <td class="filament-tables-header-cell w-2 p-2">Refund Time</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                <?php $counter = 0 ?>
                @foreach ($allSupplierDebit as $key => $purchase)
                <?php $counter++; ?>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$counter}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->purchase_number}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$purchase->transaction_amount}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$purchase->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
        <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
            <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                <div class="flex items-center">
                    <div class="pl-2 text-sm font-medium dark:text-white"></div>
                </div>
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">                          
                        @for($currentPage = 1 ; $currentPage <= $rsTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/sales-report?rsPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $rsPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
                                    >
                                        <span>{{$currentPage}}</span>
                                    </button>
                                </a>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>
            </div>
        </nav>
    </div>
</div>

<div class="summary_section">
    Total Refund from Suppliers:  ৳ {{$totalSupplierDebit}}
</div>
<br>
<!-- CUSTOMER DEBIT || PAYMENT FROM CUSTOMERS-->

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Payments from Customers</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-2 px-4">Serial</td>
                <td class="filament-tables-header-cell w-2 p-2" class="filament-tables-header-cell w-2 p-2">Order Number</td>
                <td class="filament-tables-header-cell w-2 p-2">Order Of</td>
                <td class="filament-tables-header-cell w-2 p-2">Transaction Amount</td>
                <td class="filament-tables-header-cell w-2 p-2">Transaction Message</td>
                <td class="filament-tables-header-cell w-2 p-2">Transaction Method</td>
                <td class="filament-tables-header-cell w-2 p-2">Transaction Time</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                <?php $counter = 0 ?>
                @foreach ($allCustomerDebit as $key => $sale)
                <?php $counter++; ?>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$counter}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->order_number}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$sale->transaction_amount}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->transaction_message}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->transaction_method}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
        <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
            <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                <div class="flex items-center">
                    <div class="pl-2 text-sm font-medium dark:text-white"></div>
                </div>
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">                          
                        @for($currentPage = 1 ; $currentPage <= $pcTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/sales-report?pcPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $pcPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
                                    >
                                        <span>{{$currentPage}}</span>
                                    </button>
                                </a>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>
            </div>
        </nav>
    </div>
</div>


<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$toalCustomerDebit}}
</div>
<br>
<!-- SUPPLIER CREDIT || REFUND TO CUSTOMERS-->

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Refunds to Customers</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-2 px-4">Serial</td>
                <td class="filament-tables-header-cell w-2 p-2">Order Number</td>
                <td class="filament-tables-header-cell w-2 p-2">Refund to</th>
                <td class="filament-tables-header-cell w-2 p-2">Refund Amount</td>
                <td class="filament-tables-header-cell w-2 p-2">Refund Method</th>
                <td class="filament-tables-header-cell w-2 p-2">Refund Time</th>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                <?php $counter = 0 ?>
                @foreach ($allCustomerCredit as $key => $sale)
                <?php $counter++; ?>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$counter}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->order_number}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$sale->transaction_amount}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->transaction_method}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$sale->created_at}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
        <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
            <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                <div class="flex items-center">
                    <div class="pl-2 text-sm font-medium dark:text-white"></div>
                </div>
            <div class="flex items-center justify-center">
                <div class="flex items-center space-x-2 filament-tables-pagination-records-per-page-selector rtl:space-x-reverse">
                </div>
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">                          
                        @for($currentPage = 1 ; $currentPage <= $rcTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/sales-report?rcPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $rcPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
                                    >
                                        <span>{{$currentPage}}</span>
                                    </button>
                                </a>
                            </li>
                        @endfor
                    </ol>
                </div>
            </div>
            </div>
        </nav>
    </div>
</div>

<div class="summary_section">
    Total Paid to Suppliers:  ৳ {{$toalCustomerCredit}}
</div>

<hr>
<br><br>
<!-- SALES SUMMARY-->
<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">SALES SUMMARY TABLE</caption>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-checkbox-cell w-2 px-6" colspan="2"><b>SUPPLIER</b></td>
                    <td class="filament-tables-checkbox-cell w-2 px-6" colspan="2"><b>CUSTOMER</b></td>
                </tr>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white px-6">Paid</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$totalSupplierCredit}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">Received</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$toalCustomerDebit}}</td>
                </tr>
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white px-6">Refund</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$totalSupplierDebit}}</td>
                    <td class="filament-tables-cell dark:text-white px-6">Refund</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{$toalCustomerCredit}}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

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
