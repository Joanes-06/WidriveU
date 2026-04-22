<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Setting;

class Reservation extends Model
{
    protected $fillable = [
        'reservation_number',
        'user_id',
        'vehicle_id',
        'zone_id',
        'type',
        'current_position',
        'phone',
        'email',
        'start_date',
        'end_date',
        'departure_time',
        'return_time',
        'days',
        'subtotal',
        'discount_percentage',
        'discount_amount',
        'total',
        'status',
        'cancellation_reason',
        'contract_path',
        'receipt_path',
        'paid_at',
        'transaction_id',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'paid_at' => 'datetime',
        ];
    }

    /**
     * Generate a unique reservation number in format WDU-000001.
     */
    public static function generateNumber(): string
    {
        $last = static::orderBy('id', 'desc')->first();
        $nextId = $last ? ($last->id + 1) : 1;

        return 'WDU-' . str_pad($nextId, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the discount percentage based on number of days.
     */
    public static function getDiscountPercentage(int $days): int
    {
        if ($days >= 21) {
            return (int) Setting::get('discount_21_days', 20);
        } elseif ($days >= 14) {
            return (int) Setting::get('discount_14_days', 18);
        } elseif ($days >= 7) {
            return (int) Setting::get('discount_7_days', 15);
        }

        return 0;
    }

    /**
     * Get the status label in French.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'En attente',
            'active' => 'Active',
            'completed' => 'Terminée',
            'cancelled' => 'Annulée',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get the Bootstrap badge class for the status.
     */
    public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'pending' => 'bg-warning text-dark',
            'active' => 'bg-success',
            'completed' => 'bg-primary',
            'cancelled' => 'bg-danger',
            default => 'bg-secondary',
        };
    }

    /**
     * Get the user that owns the reservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the vehicle of the reservation.
     */
    public function vehicle(): BelongsTo
    {
        return $this->belongsTo(Vehicle::class);
    }

    /**
     * Get the zone of the reservation.
     */
    public function zone(): BelongsTo
    {
        return $this->belongsTo(Zone::class);
    }

    /**
     * Check if the reservation can be cancelled by the client.
     * Conditions: pending (always), OR active with start_date > 2 hours away.
     */
    public function canBeCancelled(): bool
    {
        if ($this->status === 'pending') {
            return true;
        }

        if ($this->status === 'active') {
            $startDateTime = $this->start_date->copy();
            if ($this->departure_time) {
                $parts = explode(':', $this->departure_time);
                $startDateTime->setTime((int) $parts[0], (int) ($parts[1] ?? 0));
            } else {
                $startDateTime->setTime(0, 0);
            }
            return now()->diffInHours($startDateTime, false) > 2;
        }

        return false;
    }

    /**
     * Check if the reservation can be extended.
     */
    public function canBeExtended(): bool
    {
        return $this->extendBlockReason() === null;
    }

    /**
     * Return the reason why the reservation cannot be extended, or null if it can.
     */
    public function extendBlockReason(): ?string
    {
        // 1. Doit être active
        if ($this->status !== 'active') {
            return 'La réservation n\'est pas active (statut : ' . $this->status_label . ').';
        }

        // 2. Doit être payée
        if (!$this->paid_at) {
            return 'La réservation n\'a pas encore été payée.';
        }

        // 3. Pas d'extension déjà en cours (pending)
        if ($this->extensions()->where('status', 'pending')->exists()) {
            return 'Une demande de prolongation est déjà en cours de traitement.';
        }

        // 4. Minimum 1 heure avant la fin
        $endDateTime = $this->end_date->copy();
        if ($this->return_time) {
            $parts = explode(':', $this->return_time);
            $endDateTime->setTime((int) $parts[0], (int) ($parts[1] ?? 0));
        } else {
            $endDateTime->setTime(23, 59);
        }

        if (now()->diffInHours($endDateTime, false) < 1) {
            return 'Il doit rester au minimum 1 heure avant la fin de la location pour pouvoir prolonger.';
        }

        return null;
    }

    /**
     * Get the extensions for the reservation.
     */
    public function extensions(): HasMany
    {
        return $this->hasMany(ReservationExtension::class)->orderBy('created_at', 'desc');
    }
}
