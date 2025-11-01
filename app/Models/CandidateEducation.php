<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateEducation extends Model
{
    use HasFactory;
    protected $table = 'candidate_educations'; // specify table name if not following conventions

    protected $fillable = [
        'candidate_id',
        'degree',
        'institution',
        'result',
        'comments',
    ];

    /**
     * Relationship: one education belongs to one candidate.
     */
    public function candidate()
    {
        return $this->belongsTo(CandidateInformation::class, 'candidate_id');
    }

    
}
