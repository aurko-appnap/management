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
            self::PLACED => 'Unpaid',
            self::PROCESSING => 'Partially Paid',
            self::RECEIVED => 'Cancelled',
            self::COMPLETE => 'Paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PLACED => 'secondary',
            self::PROCESSING => 'warning',
            self::RECEIVED => 'danger',
            self::COMPLETE => 'success',
        };
    }
}