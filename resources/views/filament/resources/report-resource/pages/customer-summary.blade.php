<x-filament::page>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.js"></script>  

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
    

    <button class="collapsible general-button">Filter</button>
    <div class="collapsibleContent">
        <form action="">
            <div class="form-input-group">
                <label for="datetimerange-input1">Date Range</label>
                <input type="text" name="dateRange" class="rounded-2xl bg-white shadow dark:bg-gray-800" id="datetimerange-input1" size="20" style="text-align:center">
            </div>
            <hr>
            <div class="form-input-group">
                <label for="saleType">Payment Type</label>
                <select name="sale" id="saleType" class="rounded-2xl bg-white shadow dark:bg-gray-800">
                    <option value="">All</option>
                    <option value="0">Unpaid</option>
                    <option value="1">Partial Paid</option>
                    <option value="3">Full Paid</option>
                    <option value="2">Cancelled</option>
                </select>
            </div>
            <hr>
            <div class="form-input-group">
                <label for="spentAmount">Total Spend</label>
                <select name="spent" id="spentAmount" class="rounded-2xl bg-white shadow dark:bg-gray-800">
                    <option value="0">Any Amount</option>
                    <option value="1">More than</option>
                    <option value="2">Less Than</option>
                    <option value="3">Equal To</option>
                </select>
            </div>
            <hr>
            <div class="form-input-group">
                <label for="amount">Amount</label>
                <input type="text" name="amount" placeholder="1225.00" class="rounded-2xl bg-white shadow dark:bg-gray-800">
            </div>
            <hr>
            <div class="form-input-group">
                <label for="item">Item</label>
                <select id="item" type="text" class="livesearch p-3 rounded-2xl bg-white shadow dark:bg-gray-800" name="product_item">
                    <option value="">All</option>
                </select>
                <!-- <select name="item" id="item" class="rounded-2xl bg-white shadow dark:bg-gray-800">
                    
                </select> -->
            </div>

            <div class="form-input-group">
                <button type="submit" class="general-button">Search</button>
                <a href="{{url('/admin/reports/customer-summary')}}" class="white-button">Clear</a>
            </div>
        </form>  
    </div>

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell p-2">Customer Name</td>
                <td class="filament-tables-header-cell p-2">Order Count</td>
                <td class="filament-tables-header-cell p-2">Order Detail</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($CustomerSummary as $key => $result)
                    <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                        <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$result->name}}</td>
                        <td class="filament-tables-cell dark:text-white px-6">{{$result->order_count}}</td>
                        <td class="filament-tables-actions-cell px-6 "><a href="{{url('/admin/customers/customer-order-summary/'.$result->id)}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium hover:underline focus:outline-none focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <!-- <div class="filament-tables-pagination-container p-2 border-t dark:border-gray-700">
        <nav role="navigation" aria-label="Pagination Navigation" class="filament-tables-pagination flex items-center justify-between">
            <div class="hidden flex-1 items-center lg:grid grid-cols-3">
                <div class="flex items-center">
                    <div class="pl-2 text-sm font-medium dark:text-white"></div>
                </div>
            <div class="flex items-center justify-center">
               
            </div>
            <div class="flex items-center justify-end">
                <div class="py-3 border rounded-lg dark:border-gray-600">
                    <ol class="flex items-center text-sm text-gray-500 divide-x rtl:divide-x-reverse divide-gray-300 dark:text-gray-400 dark:divide-gray-600">                          
                        @for($currentPage = 1 ; $currentPage <= $totalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url()->full().'&page='.$currentPage}}">
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
    </div> -->
</div>

<script>
    
    window.addEventListener("load", function (event) {
        var startDate, endDate;
        new DateRangePicker('datetimerange-input1',
            {
                showWeekNumbers : true,
                timePicker24Hour : false,
                timePicker: false,
                opens: 'down',
                autoApply: true,
                ranges: {
                    'Today': [moment().startOf('day'), moment().endOf('day')],
                    'Yesterday': [moment().subtract(1, 'days').startOf('day'), moment().subtract(1, 'days').endOf('day')],
                    'Last 7 Days': [moment().subtract(6, 'days').startOf('day'), moment().endOf('day')],
                    'This Month': [moment().startOf('month').startOf('day'), moment().endOf('month').endOf('day')],
                },
                locale: {
                    format: "DD/MM/YYYY",
                    firstDay: 6,
                    monthNames: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                }
                
            },
            function (start, end) {
                // var dateValue = document.getElementById('datetimerange-input1');
                // dateValue.value = start.format('DD/MM/YYYY');
            })
            document.getElementById('datetimerange-input1').value = 'DD/MM/YYYY';
    });

    var coll = document.getElementsByClassName("collapsible");
    var i;

    for (i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        var content = this.nextElementSibling;
        if (content.style.maxHeight){
        content.style.maxHeight = null;
        } else {
        content.style.maxHeight = content.scrollHeight + "px";
        } 
    });
}

$('.livesearch').select2({
        placeholder: 'Select Item',
        ajax: {
            url: '/item-autocomplete-search',
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            cache: true
        }
    });
</script>
</x-filament::page>
