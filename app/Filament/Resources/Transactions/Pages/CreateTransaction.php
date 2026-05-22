<?php

namespace App\Filament\Resources\Transactions\Pages;

use App\Filament\Resources\Transactions\TransactionResource;
use App\Services\ProductTransactionService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Notifications\Notification;

class CreateTransaction extends CreateRecord
{
    protected static string $resource = TransactionResource::class;

    public function handleRecordCreation(array $data): Model
    {
        try {
            return app(ProductTransactionService::class)->create($data);
        } catch (\Exception $e) {
            Notification::make()
                ->title('Stock Error')
                ->body($e->getMessage())
                ->danger()
                ->send();

            $this->halt();
        }
    }
}
