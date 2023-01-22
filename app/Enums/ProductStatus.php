<?php

namespace App\Enums;

enum ProductStatus: int
{
    case AVAILABLE = 1;
    case NOT_AVAILABLE = 0;

    public function name(): string
    {
        return match ($this) {
            self::AVAILABLE => 'Available',
            self::NOT_AVAILABLE => 'Not Available',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::AVAILABLE => 'success',
            self::NOT_AVAILABLE => 'danger',
        };
    }
}