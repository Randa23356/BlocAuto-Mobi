<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'customer_id',
        'plat',
        'brand',
        'year'
    ];

    /**
     * Get the customer that owns the vehicle.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
