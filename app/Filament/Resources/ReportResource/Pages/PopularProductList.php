<?php

namespace App\Filament\Resources\ReportResource\Pages;

use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\DB;
use App\Filament\Resources\ReportResource;

class PopularProductList extends Page
{
    protected static string $resource = ReportResource::class;
    public $popularProductList, $zeroSellingProducts;

    public $topTotalPageCount, $zeroTotalPageCount;
    public $topPage;
    public $zeroPage;

    public function mount()
    {
        $topPerPageRecord = 5;
        request('topSellPage') == null ? $this->topPage = 1 : $this->topPage = request('topSellPage'); 
        request('zeroSellPage') == null ? $this->zeroPage = 1 : $this->zeroPage = request('zeroSellPage'); 

        $topPageRecordStart = ($this->topPage-1)*$topPerPageRecord;

        $popularProductListRecord = DB::table('order_items')
                    ->join('products' , 'products.id' , '=' , 'order_items.product_id')
                    ->selectRaw('order_items.product_id, COUNT(order_items.product_id) as counts, SUM(order_items.product_quantity) as p_quantity , products.name , products.price')
                    ->groupBy('order_items.product_id')
                    ->orderBy('p_quantity' , 'DESC')
                    ->get();
        
        $this->topTotalPageCount = (int)ceil(sizeof($popularProductListRecord) / $topPerPageRecord);

        $this->popularProductList = DB::table('order_items')
                    ->join('products' , 'products.id' , '=' , 'order_items.product_id')
                    ->selectRaw('order_items.product_id, COUNT(order_items.product_id) as counts, SUM(order_items.product_quantity) as p_quantity , products.name , products.price')
                    ->groupBy('order_items.product_id')
                    ->orderBy('p_quantity' , 'DESC')
                    ->limit($topPerPageRecord)
                    ->offset($topPageRecordStart)
                    ->get();


        $zeroPerPageRecord = 5;
        
        $zeroPageRecordStart = ($this->zeroPage-1)*$zeroPerPageRecord;

        $zeroSellingProductsRecord = DB::table('products')
                    ->select('*')
                    ->whereNotIn('id' , function($qr){
                        $qr->select('product_id')
                           ->from('order_items');
                    })
                    ->get();
        $this->zeroTotalPageCount = (int)ceil(sizeof($zeroSellingProductsRecord) / $zeroPerPageRecord);
        
        $this->zeroSellingProducts = DB::table('products')
                    ->select('*')
                    ->whereNotIn('id' , function($qr){
                        $qr->select('product_id')
                           ->from('order_items');
                    })
                    ->limit($zeroPerPageRecord)
                    ->offset($zeroPerPageRecord)
                    ->get();

        // dd($this->zeroSellingProducts);
    }
    protected static string $view = 'filament.resources.report-resource.pages.popular-product-list';
}
