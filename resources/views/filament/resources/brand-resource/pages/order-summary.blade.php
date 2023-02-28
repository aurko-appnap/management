<x-filament::page>
    <link rel="stylesheet" href="{{asset('css/pagination.css')}}">
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">

    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.js"></script>

    <input type="text" id="datetimerange-input1" size="24" style="text-align:center">
{{$totalOrderCount}}
<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell p-2">Order Number</td>
                <td class="filament-tables-header-cell p-2">Order By</td>
                <td class="filament-tables-header-cell p-2">Order Date</td>
                <td class="filament-tables-header-cell p-2">Shipping Address</td>
                <td class="filament-tables-header-cell p-2">Shipping Method</td>
                <td class="filament-tables-header-cell p-2">Order Price</td>
                <td class="filament-tables-header-cell p-2">Order Status</td>
                <td class="filament-tables-header-cell p-2">Order Detail</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($OrderSummary as $key => $order)
                    <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                        <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->order_number}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->name}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->order_placed_on}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->shipping_address}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->shipping_method}}</td>
                        <td class="filament-tables-cell dark:text-white">৳ {{$order->total_price}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$order->order_status}}</td>
                        <td class="filament-tables-actions-cell px-6 "><a href="{{url('/admin/orders/order-detail/'.$order->id)}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium hover:underline focus:outline-none focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">View</a></td>
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
                        @for($currentPage = 1 ; $currentPage <= $totalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/brands/order-detail/'.$brandID.'?p='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $page==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
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

<?php
if(count($OrderSummary)>0) $noDataDisplay = 'none';
else $noDataDisplay = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay}};">No Data Available!</div>

<script>
    window.addEventListener("load", function (event) {
        var startDate, endDate;
        new DateRangePicker('datetimerange-input1',
            {
                showWeekNumbers : true,
                timePicker24Hour : false,
                timePicker: true,
                opens: 'down',
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
                },
                locale: {
                    format: "DD/MM/YYYY HH:mm:ss",
                    firstDay: 6,
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                }
            },
            function (start, end) {
                // alert("<?php echo 'ok'; ?>");
                startDate = start.format("DD/MM/YYYY");
                endDate = end.format("DD/MM/YYYY");
                var url = "<?php echo url('/admin/brands/order-detail/'.$brandID.'?from=') ?>"+startDate+"&to="+endDate;
                window.location.href = url;
                // alert(url);
                // alert(start.format() + " - " + end.format());
            })
    });
</script>

</x-filament::page>
