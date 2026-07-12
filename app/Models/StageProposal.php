<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StageProposal extends Model
{
    protected $fillable = [
        'student_id',
        'company_id',
        'title',
        'description',
        'motivation',
        'start_date',
        'end_date',
        'status',
        'approved_by',
        'approved_at',
        'internship_id',
    ];

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function feedback()
    {
        return $this->hasMany(CommitteeFeedback::class);
    }

    public function internship()
    {
        return $this->belongsTo(Internship::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}