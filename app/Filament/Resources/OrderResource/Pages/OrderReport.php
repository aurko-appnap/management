<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Models\Order;
use Filament\Resources\Pages\Page;
use App\Filament\Resources\OrderResource;

class OrderReport extends Page
{   
    protected static string $resource = OrderResource::class;

    public $order;
    public $OrderId;

    protected static ?string $slug = 'order/report/{OrderId}';

    public function mount()
    {
        $paths = explode('/', isset(request()->all()['fingerprint']) ? request()->all()['fingerprint']['path'] : request()->url());
        dd($paths);
        // $this->OrderId = 1;
    }
    
    protected static string $view = 'filament.resources.order-resource.pages.order-report';
}
