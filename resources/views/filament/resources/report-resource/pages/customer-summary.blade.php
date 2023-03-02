<x-filament::page>
    <link rel="stylesheet" href="{{asset('css/custom.css')}}">
    <link type="text/css" rel="stylesheet" href="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.css">
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js" type="text/javascript"></script>
    <script src="https://cdn.jsdelivr.net/gh/alumuko/vanilla-datetimerange-picker@latest/dist/vanilla-datetimerange-picker.js"></script>  

    <button class="collapsible general-button">Filter</button>
    <div class="collapsibleContent">
        <form action="">
            <div class="form-input-group">
                <label for="datetimerange-input1">Date Range</label>
                <input type="text" name="dateRange" class="rounded-2xl bg-white shadow dark:bg-gray-800" id="datetimerange-input1" size="20" style="text-align:center">
            </div>
            <hr>
            <div class="form-input-group">
                <label for="saleType">Sale Type</label>
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

            <div class="form-input-group">
                <button type="submit" class="general-button">Search</button>
                <a href="{{url('/admin/reports/customer-summary')}}" class="white-button">Clear</a>
            </div>
        </form>  
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
    
</script>
</x-filament::page>
