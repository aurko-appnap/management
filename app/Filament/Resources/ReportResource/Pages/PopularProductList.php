<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class PopularProductList extends Page
{
    protected static string $resource = ReportResource::class;
    public $popularProductList;
    public function mount()
    {
        $this->popularProductList = DB::table('order_items')
                    ->join('products' , 'products.id' , '=' , 'order_items.product_id')
                    ->selectRaw('order_items.product_id, COUNT(order_items.product_id) as counts, SUM(order_items.product_quantity) as p_quantity , products.name , products.price')
                    ->groupBy('order_items.product_id')
                    ->orderBy('p_quantity' , 'DESC')
                    ->get();
        // dd($this->popularProductList);
    }
    protected static string $view = 'filament.resources.report-resource.pages.popular-product-list';
}
