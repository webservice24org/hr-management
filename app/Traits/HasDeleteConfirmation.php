<?php

namespace App\Traits;

use Livewire\Attributes\On;

trait HasDeleteConfirmation
{
    /**
     * Dispatch the confirm-delete event to JS.
     */
    public function confirmDelete(int $id, string $eventName = 'deleteConfirmed')
    {
        $this->dispatch('confirm-delete', [
            'id' => $id,
            'eventName' => $eventName,
        ]);
    }

    /**
     * Handles the actual deletion after JS confirmation.
     * This method must be implemented in the component
     * to actually delete the resource.
     */
    #[On('deleteConfirmed')]
    public function deleteConfirmed(array $payload)
    {
        $id = $payload['id'] ?? null;

        if (!$id) {
            return;
        }

        // Call a component method to handle deletion
        $this->performDelete($id);
    }

    /**
     * Each component should implement this method to delete the resource
     * Example: Role::find($id)->delete();
     */
    abstract protected function performDelete(int $id);
}
