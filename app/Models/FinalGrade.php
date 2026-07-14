<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FinalGrade extends Model
{
    protected $fillable = [
        'internship_id',
        'teacher_id',
        'grade',
        'feedback',
    ];

    protected function casts(): array
    {
        return [
            'grade' => 'decimal:1',
        ];
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}