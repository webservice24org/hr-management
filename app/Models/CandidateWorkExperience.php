<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CandidateWorkExperience extends Model
{
     use HasFactory;
    protected $table = 'candidate_work_experiences';
     
    protected $fillable = [
        'candidate_id',
        'company_name',
        'working_period',
        'duties',
        'supervisor',
    ];

    public function candidate()
    {
        return $this->belongsTo(CandidateInformation::class, 'candidate_id');
    }

    
}
