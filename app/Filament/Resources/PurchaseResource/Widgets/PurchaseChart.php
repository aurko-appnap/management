<?php

namespace App\Filament\Resources\PurchaseResource\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\BarChartWidget;

class PurchaseChart extends BarChartWidget
{
    protected static ?string $heading = 'Purchase Amount';

    protected function getData(): array
    {
        $purchase = DB::table('purchases')
            ->selectRaw('total_purchased_price, id, purchase_number')
            ->where('purchase_status', '!=' , '2')
            ->limit(10)
            ->orderBy('id' , 'DESC')
            ->get();
        $data = [];
        $label = [];
        $count = 10;
        foreach($purchase as $key => $item)
            {
                $label[] = $item->purchase_number;
                $count = $count - 1;
                $data[] = $item->total_purchased_price;
            }

        return [
            'datasets' => [
                [
                    'label' => 'Purchase Amount',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 1.0)',
                        'rgba(255, 159, 64, 1.0)',
                        'rgba(255, 205, 86, 1.0)',
                        'rgba(75, 192, 192, 1.0)',
                        'rgba(54, 162, 235, 1.0)',
                        'rgba(153, 102, 255, 1.0)',
                        'rgba(201, 203, 207, 1.0)',
                        'rgba(201, 209, 207, 1.0)',
                        'rgba(201, 103, 207, 1.0)',
                        'rgba(201, 165, 207, 1.0)'
                      ],
                ],
            ],
            'labels' => $label,
        ];
    }
}
