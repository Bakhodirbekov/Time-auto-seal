<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'category_id',
        'subcategory_id',
        'title',
        'description',
        'price',
        'price_visible',
        'brand',
        'model',
        'year',
        'color',
        'mileage',
        'fuel_type',
        'transmission',
        'condition',
        'location',
        'status',
        'is_hot_deal',
        'is_featured',
        'posted_at',
        'timer_end_at',
        'timer_expired',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'price_visible' => 'boolean',
        'year' => 'integer',
        'mileage' => 'integer',
        'is_hot_deal' => 'boolean',
        'is_featured' => 'boolean',
        'timer_expired' => 'boolean',
        'posted_at' => 'datetime',
        'timer_end_at' => 'datetime',
    ];

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function images()
    {
        return $this->hasMany(CarImage::class)->orderBy('order');
    }

    public function primaryImage()
    {
        return $this->hasOne(CarImage::class)->where('is_primary', true);
    }

    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function complaints()
    {
        return $this->hasMany(Complaint::class);
    }

    // Scopes
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeHotDeals($query)
    {
        return $query->where('is_hot_deal', true);
    }

    public function scopeTimerActive($query)
    {
        return $query->where('timer_expired', false)
            ->whereNotNull('timer_end_at')
            ->where('timer_end_at', '>', now());
    }

    public function scopeTimerExpired($query)
    {
        return $query->where(function ($q) {
            $q->where('timer_expired', true)
              ->orWhere(function ($q2) {
                  $q2->whereNotNull('timer_end_at')
                     ->where('timer_end_at', '<=', now());
              });
        });
    }

    // Helper Methods
    public function isTimerExpired()
    {
        if ($this->timer_expired) {
            return true;
        }
        
        if ($this->timer_end_at && $this->timer_end_at <= now()) {
            return true;
        }
        
        return false;
    }

    public function getRemainingTime()
    {
        if (!$this->timer_end_at || $this->isTimerExpired()) {
            return 0;
        }
        
        return now()->diffInSeconds($this->timer_end_at);
    }

    public function startTimer($hours = null)
    {
        $hours = $hours ?? config('app.car_timer_duration', 24);
        
        $this->posted_at = now();
        $this->timer_end_at = now()->addHours($hours);
        $this->timer_expired = false;
        $this->price_visible = false;
        $this->save();
    }

    public function expireTimer()
    {
        $this->timer_expired = true;
        $this->price_visible = true;
        $this->save();
    }
}
