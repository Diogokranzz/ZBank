<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'card_number',
        'card_holder',
        'cvv',
        'expiry_date',
        'type',
        'brand',
        'limit',
        'current_bill',
        'is_blocked',
    ];

    protected function casts(): array
    {
        return [
            'expiry_date' => 'date',
            'limit' => 'decimal:2',
            'current_bill' => 'decimal:2',
            'is_blocked' => 'boolean',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }

    public function getAvailableLimitAttribute(): float
    {
        return $this->limit - $this->current_bill;
    }

    public function getMaskedNumberAttribute(): string
    {
        return '**** **** **** ' . substr($this->card_number, -4);
    }
}
