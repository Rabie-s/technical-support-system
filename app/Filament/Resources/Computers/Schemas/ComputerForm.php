<?php

namespace App\Filament\Resources\Computers\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ComputerForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Computer Information')
                    ->description('Add or edit computer details')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('computer_number')
                            ->required(),

                        TextInput::make('ip_address')
                            ->required(),

                        Select::make('department_id')
                            ->relationship('department', 'name')
                            ->required()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
