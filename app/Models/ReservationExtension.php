<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReservationExtension extends Model
{
    protected $fillable = [
        'reservation_id',
        'new_end_date',
        'new_return_time',
        'days',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'amount',
        'status',
        'paid_at',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'new_end_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Get the reservation that owns the extension.
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }
}
