<?php

namespace App\Enums;

enum OrderStatus: int
{
    case PLACED = 0;
    case PROCESSING = 1;
    case RECEIVED = 2;
    case COMPLETE = 3;

    public function name(): string
    {
        return match ($this) {
            self::PLACED => 'Order Placed',
            self::PROCESSING => 'Order is processing',
            self::RECEIVED => 'Order has been received',
            self::COMPLETE => 'Order has been completed',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PLACED => 'warning',
            self::PROCESSING => 'primary',
            self::RECEIVED => 'danger',
            self::COMPLETE => 'success',
        };
    }
}