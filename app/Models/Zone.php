<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Zone extends Model
{
    protected $fillable = [
        'name',
    ];

    /**
     * Get the reservations for the zone.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
