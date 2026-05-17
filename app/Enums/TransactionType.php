<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionType: string implements HasLabel
{
    case ADD = 'add';
    case USE = 'use';
    case INITIAL_STOCK = 'initial_stock';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADD => 'Add',
            self::USE => 'Use',
            self::INITIAL_STOCK => 'Initial Stock',
        };
    }
}
