<x-filament::page>
<link rel="stylesheet" href="{{asset('css/custom.css')}}">
<link rel="stylesheet" href="{{asset('css/pagination.css')}}">

<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Top Selling Products</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-3 px-4">Serial</td>
                <td class="filament-tables-header-cell w-3 p-2">Product Name</td>
                <td class="filament-tables-header-cell w-3 p-2">Product Price</td>
                <td class="filament-tables-header-cell w-3 p-2">Number of Product Sold</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($popularProductList as $key => $product)
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$product->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{number_format($product->price , 2)}}</td>
                    <td class="filament-tables-cell px-6 dark:text-white">{{$product->p_quantity}}</td>
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
                        @for($currentPage = 1 ; $currentPage <= $topTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/popular-product-list?topSellPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $topPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
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
if(count($popularProductList)>0) $noDataDisplay1 = 'none';
else $noDataDisplay1 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay1}}">No Data Available!</div>


<!-- --------------------------------------------------------------- -->
<div class="border border-gray-300 shadow-sm bg-white rounded-xl filament-tables-container dark:bg-gray-800 dark:border-gray-700">
    <div class="filament-tables-table-container overflow-x-auto relative dark:border-gray-700 rounded-t-xl">
        <table class="filament-tables-table w-full text-start divide-y table-auto dark:divide-gray-700">
            <caption class="py-4">Zero Selling Products</caption>
            <thead class="bg-gray-500/5">
                <td class="filament-tables-checkbox-cell w-4 px-4">Serial</td>
                <td class="filament-tables-header-cell w-4 p-2">Product Name</td>
                <td class="filament-tables-header-cell w-4 p-2">Product Price</td>
            </thead>
            <tbody class="divide-y whitespace-nowrap dark:divide-gray-700">
                @foreach ($zeroSellingProducts as $key => $product)
                <tr class="filament-tables-row transition hover:bg-gray-50 dark:hover:bg-gray-500/10">
                    <td class="filament-tables-cell dark:text-white filament-table-cell-id px-6 py-4">{{$key+1}}</td>
                    <td class="filament-tables-cell dark:text-white">{{$product->name}}</td>
                    <td class="filament-tables-cell dark:text-white">৳ {{number_format($product->price , 2)}}</td>
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
                        @for($currentPage = 1 ; $currentPage <= $zeroTotalPageCount ; $currentPage++)
                            <li>
                                <a href="{{url('/admin/reports/popular-product-list?zeroSellPage='.$currentPage)}}">
                                    <button type="button" 
                                    class = "<?php echo $zeroPage==$currentPage ? 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none transition text-primary-600 focus:underline bg-primary-500/10 ring-2 ring-primary-500' : 'filament-tables-pagination-item relative flex items-center justify-center font-medium min-w-[2rem] px-1.5 h-8 -my-3 rounded-md outline-none hover:bg-gray-500/5 focus:bg-primary-500/10 focus:ring-2 focus:ring-primary-500 dark:hover:bg-gray-400/5 focus:text-primary-600 transition' ?>"
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
if(count($popularProductList)>0) $noDataDisplay2 = 'none';
else $noDataDisplay2 = '';
?>
<div class="no_data_text" style="display: {{$noDataDisplay2}}">No Data Available!</div>
    
</x-filament::page>
