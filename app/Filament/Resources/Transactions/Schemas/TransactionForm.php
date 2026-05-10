<?php

namespace App\Filament\Resources\Transactions\Schemas;

use App\Enums\TransactionType;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class TransactionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Transaction Information')
                    ->columnSpanFull()
                    ->columns(2)
                    ->schema([
                        Select::make('product_id')
                            ->relationship('product', 'name')
                            ->required(),

                        Select::make('department_id')
                            ->relationship('department', 'name'),

                        Select::make('type')
                            ->options(TransactionType::class)
                            ->required(),

                        TextInput::make('qty')
                            ->required()
                            ->numeric()
                            ->minValue(1)
                            ->live()
                            ->rules([
                                fn(callable $get) => function (string $attribute, mixed $value, \Closure $fail) use ($get) {
                                //dd($get('type')->value);    
                                if ($get('type')->value !== TransactionType::USE->value) {
                                        return;
                                    }

                                    $product = Product::select('id')->find($get('product_id'));

                                    if (! $product) {
                                        return;
                                    }

                                    if ((int) $value > $product->stock) {
                                        $fail("Only {$product->stock} unit(s) available in stock.");
                                    }
                                },
                            ]),

                        Textarea::make('note')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
