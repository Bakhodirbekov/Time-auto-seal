<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'car_id',
        'image_path',
        'is_primary',
        'order',
    ];

    protected $appends = ['image_url'];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
    ];

    // Relationships
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Accessor for full URL
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}
