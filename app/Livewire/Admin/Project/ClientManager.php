<?php

namespace App\Livewire\Admin\Project;

use Livewire\Component;
use App\Models\Client;

class ClientManager extends Component
{
    public $showModal = false;

    public $client_id;
    public $client_name;
    public $company_name;
    public $email;
    public $mobile;
    public $country;
    public $address;
    public $status = true;

    protected function rules()
    {
        return [
            'client_name'  => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'email'        => 'nullable|email|unique:clients,email,' . $this->client_id,
            'mobile'       => 'nullable|string|max:20',
            'country'      => 'nullable|string|max:100',
            'address'      => 'nullable|string',
            'status'       => 'boolean',
        ];
    }

    /* ---------------- MODAL ---------------- */

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

    /* ---------------- CRUD ---------------- */

    public function save()
    {
        $this->validate();

        Client::updateOrCreate(
            ['id' => $this->client_id],
            [
                'client_name'  => $this->client_name,
                'company_name' => $this->company_name,
                'email'        => $this->email,
                'mobile'       => $this->mobile,
                'country'      => $this->country,
                'address'      => $this->address,
                'status'       => $this->status,
            ]
        );

        $this->dispatch('toastMagic',
            status: 'success',
            title: 'Saved',
            message: 'Client saved successfully.'
        );

        $this->closeModal();
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);

        $this->client_id    = $client->id;
        $this->client_name  = $client->client_name;
        $this->company_name = $client->company_name;
        $this->email        = $client->email;
        $this->mobile       = $client->mobile;
        $this->country      = $client->country;
        $this->address      = $client->address;
        $this->status       = $client->status;

        $this->showModal = true;
    }

    public function toggleStatus($id)
    {
        Client::findOrFail($id)
            ->update(['status' => !Client::find($id)->status]);
    }

    public function delete($id)
    {
        Client::findOrFail($id)->delete();
    }

    private function resetForm()
    {
        $this->reset([
            'client_id',
            'client_name',
            'company_name',
            'email',
            'mobile',
            'country',
            'address',
            'status',
        ]);

        $this->status = true;
    }

    public function render()
    {
        return view('livewire.admin.project.client-manager', [
            'clients' => Client::latest()->get(),
        ]);
    }
}
