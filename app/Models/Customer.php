<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address'
    ];

    /**
     * Get the vehicles for the customer.
     */
    public function vehicles()
    {
        return $this->hasMany(Vehicle::class);
    }
}
