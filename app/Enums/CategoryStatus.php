<?php

namespace App\Enums;

enum CategoryStatus: int
{
    case ACTIVE = 1;
    case NOT_ACTIVE = 0;

    public function name(): string
    {
        return match ($this) {
            self::ACTIVE => 'Active',
            self::NOT_ACTIVE => 'Not Active',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ACTIVE => 'success',
            self::NOT_ACTIVE => 'danger',
        };
    }
}