<?php

namespace App\Enums;

use Filament\Support\Contracts\HasLabel;

enum UnitType: string implements HasLabel
{
    case PIECE = 'piece';
    case BOX = 'box';

    public function getLabel(): string
    {
        return match ($this) {
            self::PIECE => 'Piece',
            self::BOX => 'Box',
        };
    }
}