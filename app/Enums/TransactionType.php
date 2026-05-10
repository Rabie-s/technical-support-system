<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum TransactionType: string implements HasLabel
{
    case ADD = 'add';
    case USE = 'use';

    public function getLabel(): string
    {
        return match ($this) {
            self::ADD => 'Add',
            self::USE => 'Use',
        };
    }
}
