<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = [
        'name',
        'role',
    ];

    /**
     * Get the role name attribute.
     *
     * @return string
     */
    public function getRoleNameAttribute()
    {
        $roles = [
            'mechanic' => 'Mekanik',
            'chasier' => 'Kasir',
            'admin' => 'Admin',
        ];

        return $roles[$this->role] ?? $this->role;
    }
}
