<?php

namespace App\Models;

use App\Enums\TransactionType;
use App\Enums\UnitType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'brand',
        'item_type_id',
        'unit',
        'min_qty',
        'image',
        'notes',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'unit' => UnitType::class,
        ];
    }

    /**
     * Get the item type that owns the product.
     */
    public function itemType(): BelongsTo
    {
        return $this->belongsTo(ItemType::class);
    }

    /**
     * Get all transactions for the product.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    /**
     * Calculate current stock based on transactions.
     */
    public function getStockAttribute(): int
    {
        $initial_stock = $add = $this->transactions()
            ->where('type', TransactionType::INITIAL_STOCK)
            ->sum('qty');

        $add = $this->transactions()
            ->where('type', TransactionType::ADD)
            ->sum('qty');

        $use = $this->transactions()
            ->where('type', TransactionType::USE)
            ->sum('qty');

        return $initial_stock + $add - $use;
    }

    public function totalPurchased(): int
    {
        return $this->transactions()
            ->whereIn('type', [
                TransactionType::ADD,
                TransactionType::INITIAL_STOCK,
            ])
            ->sum('qty');
    }

    public function totalUsed(): int
    {
        return $this->transactions()
            ->whereIn('type', [
                TransactionType::USE,
            ])
            ->sum('qty');
    }
}
