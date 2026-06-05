<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogbookVV extends Model
{
    protected $table = 'logbooks';

    protected $fillable = [
        'internship_id',
        'week_number',
        'tasks',
        'reflection',
        'problems',
        'lessons_learned',
        'approved',
    ];

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }
}