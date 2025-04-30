<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'plate_number',
        'transmission',
        'car_type_id',
        'branch_id',
        'daily_rate',
        'is_available',
    ];

    protected $casts = [
        'is_available' => 'boolean',
        'daily_rate' => 'decimal:2',
    ];

    public function carType()
    {
        return $this->belongsTo(CarType::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
}
