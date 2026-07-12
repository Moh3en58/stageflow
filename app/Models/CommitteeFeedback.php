<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CommitteeFeedback extends Model
{
    protected $table = 'committee_feedback';

    protected $fillable = [
        'stage_proposal_id',
        'committee_user_id',
        'feedback',
        'decision',
    ];

    public function stageProposal()
    {
        return $this->belongsTo(StageProposal::class);
    }

    public function committeeUser()
    {
        return $this->belongsTo(User::class, 'committee_user_id');
    }
}