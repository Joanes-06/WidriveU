<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'brand',
        'model',
        'category',
        'year',
        'license_plate',
        'seats',
        'fuel_type',
        'transmission',
        'description',
        'photo',
        'image_2',
        'image_3',
        'image_4',
        'status',
        'price_without_driver',
        'price_with_driver',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
            'year' => 'integer',
            'seats' => 'integer',
            'price_without_driver' => 'integer',
            'price_with_driver' => 'integer',
        ];
    }

    public const CATEGORIES = [
        'Berline'   => 'Berline',
        'SUV'       => 'SUV',
        '4x4'       => '4x4 / Tout-terrain',
        'Pick-up'   => 'Pick-up',
        'Minibus'   => 'Minibus',
        'Luxe'      => 'Luxe',
        'Toyota'    => 'Toyota',
        'Honda'     => 'Honda',
        'Nissan'    => 'Nissan',
        'Hyundai'   => 'Hyundai',
        'Mercedes'  => 'Mercedes',
        'Autre'     => 'Autre',
    ];

    /**
     * Scope for available vehicles.
     */
    public function scopeDisponible(Builder $query): Builder
    {
        return $query->where('status', 'disponible');
    }

    /**
     * Get the photo URL attribute.
     */
    public function getPhotoUrlAttribute(): string
    {
        if ($this->photo && file_exists(public_path('uploads/vehicles/' . $this->photo))) {
            return asset('uploads/vehicles/' . $this->photo);
        }

        return asset('assets/images/car-placeholder.png');
    }

    /**
     * Get URL for gallery image 2, 3 or 4. Returns null if not set.
     */
    public function getImage2UrlAttribute(): ?string
    {
        if ($this->image_2 && file_exists(public_path('uploads/vehicles/' . $this->image_2))) {
            return asset('uploads/vehicles/' . $this->image_2);
        }
        return null;
    }

    public function getImage3UrlAttribute(): ?string
    {
        if ($this->image_3 && file_exists(public_path('uploads/vehicles/' . $this->image_3))) {
            return asset('uploads/vehicles/' . $this->image_3);
        }
        return null;
    }

    public function getImage4UrlAttribute(): ?string
    {
        if ($this->image_4 && file_exists(public_path('uploads/vehicles/' . $this->image_4))) {
            return asset('uploads/vehicles/' . $this->image_4);
        }
        return null;
    }

    /**
     * Return all gallery images (main + extras) as an array of URLs.
     */
    public function getGalleryUrlsAttribute(): array
    {
        $urls = [$this->photo_url];
        foreach (['image_2_url', 'image_3_url', 'image_4_url'] as $attr) {
            $url = $this->$attr;
            if ($url !== null) {
                $urls[] = $url;
            }
        }
        return $urls;
    }

    /**
     * Get the status label in French.
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'disponible' => 'Disponible',
            'reservee' => 'Réservée',
            'maintenance' => 'En maintenance',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get the reservations for the vehicle.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }
}
