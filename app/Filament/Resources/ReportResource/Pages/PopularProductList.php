<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class PopularProductList extends Page
{
    protected static string $resource = ReportResource::class;
    public $popularProductList, $zeroSellingProducts;
    public function mount()
    {
        $this->popularProductList = DB::table('order_items')
                    ->join('products' , 'products.id' , '=' , 'order_items.product_id')
                    ->selectRaw('order_items.product_id, COUNT(order_items.product_id) as counts, SUM(order_items.product_quantity) as p_quantity , products.name , products.price')
                    ->groupBy('order_items.product_id')
                    ->orderBy('p_quantity' , 'DESC')
                    ->get();
        $this->zeroSellingProducts = DB::table('products')
                    ->select('*')
                    ->whereNotIn('id' , function($qr){
                        $qr->select('product_id')
                           ->from('order_items');
                    })
                    ->get();

        // dd($this->zeroSellingProducts);
    }
    protected static string $view = 'filament.resources.report-resource.pages.popular-product-list';
}
