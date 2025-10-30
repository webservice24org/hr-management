import '../../vendor/rappasoft/laravel-livewire-tables/resources/imports/laravel-livewire-tables.js';

window.confirmDelete = function (eventName, payload) {
    Swal.fire({
        title: 'Are you sure?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e3342f',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, delete it!',
    }).then((result) => {
        if (result.isConfirmed) {
            window.Livewire.dispatch(eventName, payload);
        }
    });
};

document.addEventListener("DOMContentLoaded", function () {
    if (window.Livewire) {
        window.Livewire.on('confirm-delete', (payload) => {
            confirmDelete('deleteConfirmed', payload);
        });
    }
});

