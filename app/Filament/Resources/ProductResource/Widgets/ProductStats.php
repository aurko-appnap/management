<?php

namespace App\Filament\Resources\ProductResource\Widgets;

use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\StatsOverviewWidget\Card;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class ProductStats extends BaseWidget
{
    protected function getCards(): array
    {
        $total_product = Product::all()->count();
        $available_products = Product::where('inventory' , '>' , 0)->count();
        $available_percentage = ($available_products/$total_product)*100;
        $available_percentage = number_format((double)$available_percentage, 2, '.', '');
        
        $popular_product_id = DB::table('order_items')
                            ->selectRaw('product_id, COUNT(product_id) as counts, SUM(product_quantity) as p_quantity')
                            ->groupBy('product_id')
                            ->orderBy('p_quantity' , 'DESC')
                            ->first();
        $product = Product::find($popular_product_id->product_id);

        return [
            Card::make('Total Products (Available)', $total_product.'('.$available_products.')')
                ->description('['.$available_percentage.'% products available]')
                ->color('warning'),
                
            Card::make('Popular Most Product', $product->name)
                ->description($popular_product_id->p_quantity.' items have been sold')
                ->descriptionIcon('heroicon-s-trending-up')
                ->color('success'),
            Card::make('Average time on page', '3:12'),
        ];
    }
}
