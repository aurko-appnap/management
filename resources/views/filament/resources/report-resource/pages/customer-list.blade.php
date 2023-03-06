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
            <label for="item">Customer</label>
            <select id="item" type="text" class="livesearch rounded-2xl bg-white shadow dark:bg-gray-800" name="customer"></select>
            <input type="checkbox" name="all_customer" value="1"> All Customer
        </div>

        <div class="form-input-group">
            <button type="submit" class="general-button">Search</button>
            <a href="{{url('/admin/reports/customer-list')}}" class="white-button">Clear</a>
        </div>
    </form>  
</div>

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell p-2">Customer Name</td>
                <td class="filament-tables-header-cell p-2">Customer Detail</td>
                <td class="filament-tables-header-cell p-2">Order Detail</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($CustomerDetail as $key => $result)
                    <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                        <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                        <td class="filament-tables-cell dark:text-white">{{$result->name}}</td>
                        <td class="filament-tables-actions-cell px-6 "><a href="{{url('/admin/reports/customer-detail?customer='.$result->id)}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium hover:underline focus:outline-none focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">View</a></td>
                        <td class="filament-tables-actions-cell px-6 "><a href="{{url('/admin/customers/customer-order-summary/'.$result->id)}}" class="filament-link inline-flex items-center justify-center gap-0.5 font-medium hover:underline focus:outline-none focus:underline text-sm text-primary-600 hover:text-primary-500 dark:text-primary-500 dark:hover:text-primary-400 filament-tables-link-action">View</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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
        placeholder: 'Select Customer',
        ajax: {
            url: '/customer-autocomplete-search',
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
