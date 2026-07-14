<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    protected $fillable = [
        'internship_id',
        'evaluator_id',
        'evaluation_type',
        'evaluator_role',
        'evaluation_date',
        'comments',
    ];

    protected function casts(): array
    {
        return [
            'evaluation_date' => 'date',
        ];
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function evaluator()
    {
        return $this->belongsTo(User::class, 'evaluator_id');
    }

    public function scores()
    {
        return $this->hasMany(EvaluationScore::class);
    }
}