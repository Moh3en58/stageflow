<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'contact_person',
    ];

    public function internships()
    {
        return $this->hasMany(Internship::class);
    }
}