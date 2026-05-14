<?php

namespace App\Filament\Resources\Admins\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;

class AdminForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Admin Details')
                    ->description('Enter the administrator information')
                    ->icon(Heroicon::OutlinedUser)
                    ->columnSpanFull()
                    ->schema([
                        TextInput::make('name')
                            ->placeholder('Enter full name')
                            ->required(),
                        TextInput::make('email')
                            ->label('Email address')
                            ->placeholder('admin@example.com')
                            ->email()
                            ->required(),
                        TextInput::make('password')
                            ->password()
                            ->revealable()
                            ->placeholder('Enter password')
                            ->required(fn(string $operation): bool => $operation === 'create')
                            ->dehydrated(fn(?string $state): bool => filled($state))
                            ->minLength(8),
                        Select::make('roles')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->preload()
                            ->searchable()
                            ->placeholder('Select roles'),
                    ]),
            ]);
    }
}
