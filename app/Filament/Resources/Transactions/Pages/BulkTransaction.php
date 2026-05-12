<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use Filament\Resources\Pages\Page;

use App\Enums\TransactionType;

use App\Models\Department;
use App\Models\Product;
use App\Models\Transaction;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;

use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;

class BulkTransaction extends Page
{
    protected static string $resource = TransactionResource::class;

    protected string $view = 'filament.resources.transactions.pages.bulk-transaction';

     public function form(Schema $schema): Schema
    {
        return $schema
            ->statePath('data')
            ->components([
                Grid::make(2)->schema([
                    Select::make('department_id')
                        ->label('Department')
                        ->options(Department::pluck('name', 'id'))
                        ->searchable()
                        ->nullable(),

                    Textarea::make('note')
                        ->label('General note')
                        ->nullable()
                        ->rows(1),
                ]),

                Repeater::make('items')
                    ->label('Products')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->options(Product::pluck('name', 'id'))
                            ->searchable()
                            ->required(),

                        Select::make('type')
                            ->label('Type')
                            ->options(TransactionType::class)
                            ->required()
                            ->native(false),

                        TextInput::make('qty')
                            ->label('Quantity')
                            ->numeric()
                            ->required()
                            ->minValue(1)
                            ->default(1),

                        Textarea::make('note')
                            ->label('Note')
                            ->nullable()
                            ->rows(1),
                    ])
                    ->columns(4)
                    ->defaultItems(1)
                    ->addActionLabel('Add product')
                    ->reorderable(false),
            ]);
    }
}
