<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'mechanic_id',
        'vehicle_id',
        'chasier_id',
        'customer_id',
        'quantity',
        'date',
        'grand_total',
        'description',
        'spare_parts',
    ];

    public function mechanic()
    {
        return $this->belongsTo(User::class, 'mechanic_id');
    }

    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id');
    }

    public function chasier()
    {
        return $this->belongsTo(User::class, 'chasier_id');
    }

    public function sparePart()
    {
        return $this->belongsTo(SparePart::class, 'spare_parts');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }
}
