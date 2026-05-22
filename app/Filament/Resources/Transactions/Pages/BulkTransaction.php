<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
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
use Filament\Resources\Pages\Page;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Illuminate\Support\Facades\DB;
use App\Enums\TransactionType;
use App\Services\ProductTransactionService;

class BulkTransaction extends Page implements HasForms
{
    use InteractsWithForms;

    protected static string $resource = TransactionResource::class;

    protected string $view = 'filament.resources.transactions.pages.bulk-transaction';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Grid::make(2)
                    ->schema([
                        Select::make('department_id')
                            ->label('Department')
                            ->options(Department::pluck('name', 'id'))
                            ->searchable(),

                        Select::make('type')
                            ->label('Transaction Type')
                            ->required()
                            ->options(TransactionType::class)
                            ->reactive(),
                    ]),

                Repeater::make('products')
                    ->label('Products')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->required()
                            ->options(Product::pluck('name', 'id'))
                            ->searchable()
                            ->reactive(),

                        TextInput::make('qty')
                            ->label('Quantity')
                            ->required()
                            ->numeric()
                            ->minValue(1),

                        Textarea::make('note')
                            ->label('Note')
                            ->rows(2),
                    ])
                    ->columns(3)
                    ->defaultItems(1)
                    ->minItems(1)
                    ->maxItems(10),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        try {
            DB::transaction(function () use ($data) {
                $service = app(ProductTransactionService::class);

                foreach ($data['products'] as $row) {
                    $service->create([
                        'product_id'    => $row['product_id'],
                        'department_id' => $data['department_id'],
                        'type'          => $data['type'],
                        'qty'           => $row['qty'],
                        'note'          => $row['note'] ?? null,
                    ]);
                }
            });

            Notification::make()
                ->title('Transactions saved successfully')
                ->success()
                ->send();

            $this->form->fill();
        } catch (\Exception $e) {
            Notification::make()
                ->title('Stock Error')
                ->body($e->getMessage())
                ->danger()
                ->send();
        }
    }
}
