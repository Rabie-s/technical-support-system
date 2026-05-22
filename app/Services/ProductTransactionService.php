<?php

namespace App\Services;

use App\Enums\TransactionType;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class ProductTransactionService
{

    public function create(array $data): Transaction
    {

        return DB::transaction(function () use ($data) {
            // Validate stock availability
            $this->validateStockAvailability($data);

            // Create transaction
            $transaction = Transaction::create($data);

            // Update product stock if needed
            // $this->updateProductStock($transaction);

            return $transaction;
        });
    }
    private function validateStockAvailability(array $data): void
    {
        if ($data['type'] !== TransactionType::USE) {
            return;
        }

        $product = Product::find($data['product_id']);

        if ($data['qty'] > $product->stock) {
            throw new \Exception("Only {$product->stock} unit(s) available.");
        }
    }
}
