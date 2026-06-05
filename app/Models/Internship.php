<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Internship extends Model
{
    protected $fillable = [
        'user_id',
        'company_id',
        'title',
        'description',
        'start_date',
        'end_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function logbooks()
    {
        return $this->hasMany(Logbook::class);
    }

    public function evaluations()
    {
        return $this->hasMany(Evaluation::class);
    }
}