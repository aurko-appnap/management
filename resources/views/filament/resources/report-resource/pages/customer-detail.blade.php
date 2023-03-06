<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<style>
.border{
    width: 60% !important;
    margin-left: auto;
    margin-right: auto;
}
table{
    background-color: white;
    margin-left: auto;
    margin-right: auto;
    width: 60% !important;
    border-collapse: collapse;
}
td{
    padding: 15px;
}
tr:nth-child(odd){
    border-bottom: 1px solid #ddd;
}
</style>
<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
    <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
        <tr>
            <td>Customer Name</td>
            <td>{{$name}}</td>
        </tr>
        <tr>
            <td>Customer Phone</td>
            <td>{{$phone}}</td>
        </tr>
        <tr>
            <td>Customer Email</td>
            <td>{{$email}}</td>
        </tr>
        <tr>
            <td>Registered On</td>
            <td>{{$registered_on}}</td>
        </tr>
    </tbody>
</table>
</div>
</div>
</x-filament::page>
