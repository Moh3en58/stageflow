<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Competency extends Model
{
    protected $fillable = [
        'title',
        'description',
        'weight',
        'active',
    ];

    protected $casts = [
        'weight' => 'integer',
        'active' => 'boolean',
    ];

    public function evaluationScores(): HasMany
    {
        return $this->hasMany(EvaluationScore::class);
    }
}