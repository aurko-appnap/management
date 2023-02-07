<?php

namespace App\Enums;

enum OrderStatus: int
{
    case UNPAID = 0;
    case PARTIAL_PAID = 1;
    case CANCELLED = 2;
    case PAID = 3;

    public function name(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PARTIAL_PAID => 'Partially Paid',
            self::CANCELLED => 'Cancelled',
            self::PAID => 'Paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::UNPAID => 'secondary',
            self::PARTIAL_PAID => 'warning',
            self::CANCELLED => 'danger',
            self::PAID => 'success',
        };
    }
}