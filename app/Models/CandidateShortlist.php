<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CandidateInformation;

class CandidateShortlist extends Model
{
   use HasFactory;

    protected $fillable = [
        'candidate_id',
        'candidate_apply_id',
        'interview_date',
        'listed_by',
    ];

    // Relationships
    public function candidate()
    {
        return $this->belongsTo(CandidateInformation::class, 'candidate_id');
    }

    public function listedBy()
    {
        return $this->belongsTo(User::class, 'listed_by');
    }
}
