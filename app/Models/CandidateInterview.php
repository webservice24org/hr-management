<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\CandidateInformation;
use App\Models\User;
use App\Models\Position;
use App\Models\CandidateShortlist;

class CandidateInterview extends Model
{
    use HasFactory;

    protected $fillable = [
        'candidate_id',
        'interviewer',
        'position_id',
        'interview_date',
        'viva_marks',
        'written_marks',
        'mcq_marks',
        'total_marks',
        'recommendation_note',
        'selection',
        'interviewer_comments',
    ];

    protected static function booted()
    {
        // Automatically fill interview_date & calculate total_marks
        static::creating(function ($interview) {
            // Fill interview_date from shortlist if available
            $shortlist = CandidateShortlist::where('candidate_id', $interview->candidate_id)->first();
            if ($shortlist && !$interview->interview_date) {
                $interview->interview_date = $shortlist->interview_date;
            }

            // Compute total marks
            $interview->total_marks =
                ($interview->viva_marks ?? 0) +
                ($interview->written_marks ?? 0) +
                ($interview->mcq_marks ?? 0);
        });

        static::updating(function ($interview) {
            $interview->total_marks =
                ($interview->viva_marks ?? 0) +
                ($interview->written_marks ?? 0) +
                ($interview->mcq_marks ?? 0);
        });
    }

    // Relationships
    public function candidate()
    {
        return $this->belongsTo(CandidateInformation::class, 'candidate_id');
    }

    public function interviewerUser()
    {
        return $this->belongsTo(User::class, 'interviewer');
    }

    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }
}
