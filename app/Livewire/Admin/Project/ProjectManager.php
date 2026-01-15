<?php

namespace App\Livewire\Admin\Project;

use Livewire\Component;
use App\Models\Project;
use App\Models\Client;
use App\Models\User;
use App\Models\ProjectTeamMember;

class ProjectManager extends Component
{
    public $showModal = false;

    public $project_id;
    public $client_id;
    public $team_leader_id;
    public $project_name;
    public $project_code;
    public $start_date;
    public $end_date;
    public $status = 'pending';
    public $description;

    public $team_members = []; // user IDs

    protected function rules()
    {
        return [
            'client_id'       => 'required|exists:clients,id',
            'team_leader_id'  => 'nullable|exists:users,id',
            'project_name'    => 'required|string|max:255',
            'project_code'    => 'nullable|string|max:50',
            'start_date'      => 'nullable|date',
            'end_date'        => 'nullable|date|after_or_equal:start_date',
            'status'          => 'required',
            'team_members.*'  => 'exists:users,id',
        ];
    }

    public function openModal()
    {
        $this->resetForm();
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->resetForm();
        $this->showModal = false;
    }

    public function save()
    {
        $this->validate();

        $project = Project::updateOrCreate(
            ['id' => $this->project_id],
            [
                'client_id'      => $this->client_id,
                'team_leader_id' => $this->team_leader_id,
                'project_name'   => $this->project_name,
                'project_code'   => $this->project_code,
                'start_date'     => $this->start_date,
                'end_date'       => $this->end_date,
                'status'         => $this->status,
                'description'    => $this->description,
            ]
        );

        // 🔹 Sync Team Members
        ProjectTeamMember::where('project_id', $project->id)->delete();

        foreach ($this->team_members as $userId) {
            ProjectTeamMember::create([
                'project_id' => $project->id,
                'user_id'    => $userId,
            ]);
        }

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Saved',
            message: 'Project saved successfully.'
        );

        $this->closeModal();
    }

    public function edit($id)
    {
        $project = Project::with('members')->findOrFail($id);

        $this->project_id     = $project->id;
        $this->client_id      = $project->client_id;
        $this->team_leader_id = $project->team_leader_id;
        $this->project_name   = $project->project_name;
        $this->project_code   = $project->project_code;
        $this->start_date     = $project->start_date;
        $this->end_date       = $project->end_date;
        $this->status         = $project->status;
        $this->description    = $project->description;

        $this->team_members = $project->members->pluck('user_id')->toArray();

        $this->showModal = true;
    }

    public function delete($id)
    {
        Project::findOrFail($id)->delete();
    }

    private function resetForm()
    {
        $this->reset([
            'project_id',
            'client_id',
            'team_leader_id',
            'project_name',
            'project_code',
            'start_date',
            'end_date',
            'status',
            'description',
            'team_members',
        ]);

        $this->status = 'pending';
    }

    public function render()
    {
        return view('livewire.admin.project.project-manager', [
            'projects' => Project::with(['client', 'teamLeader', 'members.user'])->get(),
            'clients'  => Client::orderBy('client_name')->get(),
            'users'    => User::orderBy('name')->get(),
        ]);
    }
}


