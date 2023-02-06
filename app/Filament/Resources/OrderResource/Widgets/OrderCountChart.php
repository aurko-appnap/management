<?php

namespace App\Filament\Resources\OrderResource\Widgets;

use Illuminate\Support\Facades\DB;
use Filament\Widgets\LineChartWidget;

class OrderCountChart extends LineChartWidget
{
    protected static ?string $heading = 'Order Amount';

    protected function getData(): array
    {
        $order = DB::table('orders')
                ->selectRaw('total_price, id')
                ->where('order_status', '!=' , '2')
                ->limit(10)
                ->orderBy('id' , 'DESC')
                ->get();
        $data = [];
        $label = [];
        $count = 0;
        foreach($order as $key => $item)
            {
                $label[] = $count;
                $count = $count + 1;
                $data[] = $item->total_price;
            }
        
        // dd($data);
        
        return [
            'datasets' => [
                [
                    'label' => 'Amount of Last Orders',
                    'data' => $data,
                ],
            ],
            'labels' => $label,
        ];
    }
}
