<?php

namespace App\Enums;

enum PurchaseStatus: int
{
    case UNPAID         = 0;
    case PARTIALLY_PAID = 1;
    case CANCELLED      = 2;
    case PAID           = 3;

    public function name(): string
    {
        return match ($this) {
            self::UNPAID => 'Unpaid',
            self::PARTIALLY_PAID => 'Partially Paid',
            self::CANCELLED => 'Cancelled',
            self::PAID => 'Paid',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::UNPAID => 'secondary',
            self::PARTIALLY_PAID => 'warning',
            self::CANCELLED => 'danger',
            self::PAID => 'success',
        };
    }
}