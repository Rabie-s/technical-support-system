<?php

namespace App\Filament\Resources\Products\RelationManagers;


use App\Enums\TransactionType;
use Filament\Notifications\Notification;
use App\Services\ProductTransactionService;
use Filament\Actions\CreateAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class TransactionsRelationManager extends RelationManager
{
    protected static string $relationship = 'transactions';

    //protected static ?string $relatedResource = TransactionResource::class;

    public function isReadOnly(): bool
    {
        return false;
    }


    public function form(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('type')
                ->options(TransactionType::class)
                ->required()
                ->native(false),

            TextInput::make('qty')
                ->label('Quantity')
                ->numeric()
                ->required()
                ->minValue(1),

            Select::make('department_id')
                ->label('Department')
                ->relationship('department', 'name')
                ->searchable()
                ->preload()
                ->nullable(),

            Textarea::make('note')
                ->nullable()
                ->columnSpanFull(),
        ]);
    }


    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('id')
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('type')
                    ->badge(),

                TextColumn::make('qty')
                    ->label('Quantity'),

                TextColumn::make('department.name')
                    ->placeholder('—'),

                TextColumn::make('note')
                    ->limit(40)
                    ->placeholder('—'),

                TextColumn::make('createdBy.name')
                    ->label('By'),

                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->label('Add transaction')
                    ->using(function (array $data, CreateAction $action) {
                        $data['product_id'] = $this->getOwnerRecord()->id;

                        try {
                            return app(ProductTransactionService::class)->create($data);
                        } catch (\Exception $e) {
                            Notification::make()
                                ->title('Stock Error')
                                ->body($e->getMessage())
                                ->danger()
                                ->send();

                            $action->cancel();
                        }
                    }),
            ])
            ->actions([
                ViewAction::make(),
            ])
            ->bulkActions([]);
    }
}
