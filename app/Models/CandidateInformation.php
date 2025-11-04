<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use App\Models\Position;
use App\Models\CandidateEducation;
use App\Models\CandidateWorkExperience;

class CandidateInformation extends Model
{

    use HasFactory;
    protected $table = 'candidate_informations';

    protected $fillable = [
        'candidate_apply_id',
        'position_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'alternative_phone',
        'present_address',
        'permanent_address',
        'division',
        'city',
        'post_code',
        'picture',
        'status',
    ];

    protected $casts = [
        'post_code' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function ($model) {
            if (empty($model->candidate_apply_id)) {
                // generate alphanumeric 20-char unique id (tries until unique)
                do {
                    $candidateApplyId = Str::upper(Str::random(20));
                } while (self::where('candidate_apply_id', $candidateApplyId)->exists());

                $model->candidate_apply_id = $candidateApplyId;
            }
        });
    }

    public function educations()
    {
        return $this->hasMany(CandidateEducation::class, 'candidate_id');
    }

    public function workExperiences()
    {
        return $this->hasMany(CandidateWorkExperience::class, 'candidate_id');
    }


    /**
     * Relationship to position
     */
    public function position()
    {
        return $this->belongsTo(Position::class, 'position_id');
    }



    // Relationship to candidate work experiences
    public function experiences()
    {
        return $this->hasMany(CandidateWorkExperience::class, 'candidate_id');
    }

    /**
     * Helper for full name
     */
    public function getFullNameAttribute(): string
    {
        return trim("{$this->first_name} {$this->last_name}");
    }



}
