<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Client;
use App\Models\User;
use App\Models\ProjectTeamMember;

class Project extends Model
{
    protected $fillable = [
        'client_id',
        'team_leader_id',
        'project_name',
        'project_code',
        'start_date',
        'end_date',
        'status',
        'description',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function teamLeader()
    {
        return $this->belongsTo(User::class, 'team_leader_id');
    }

    public function members()
    {
        return $this->hasMany(ProjectTeamMember::class);
    }
}


