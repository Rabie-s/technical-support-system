<?php

namespace App\Filament\Resources\Products\Schemas;

use App\Enums\UnitType;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Add new item')
                    ->description('The items you have selected for purchase')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->required(),

                        TextInput::make('brand'),

                        Select::make('item_type_id')
                            ->relationship('itemType', 'name')
                            ->required(),

                        Select::make('unit')
                            ->options(UnitType::class)
                            ->required(),

                        TextInput::make('min_qty')
                            ->required()
                            ->numeric()
                            ->default(0),

                        Textarea::make('notes')
                            ,

                        FileUpload::make('image')
                            ->image()
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
