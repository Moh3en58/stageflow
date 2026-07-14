<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EvaluationScore extends Model
{
    protected $fillable = [
        'evaluation_id',
        'competency_id',
        'score',
        'comment',
    ];

    public function evaluation()
    {
        return $this->belongsTo(Evaluation::class);
    }

    public function competency()
    {
        return $this->belongsTo(Competency::class);
    }
}