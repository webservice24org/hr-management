<?php

use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Livewire\Volt\Volt;
use App\Livewire\Admin\Users\UserList;
use App\Livewire\Admin\Users\PermissionManager;
use App\Livewire\Admin\Users\RoleManager;
use App\Livewire\Admin\Department\DepartmentManager;
use App\Livewire\Admin\SubDepartment\SubDepartmentManager;
use App\Exports\SubDepartmentsTemplateExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DepartmentTemplateExport;
use App\Livewire\Admin\Employee\PositionManager;


Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Volt::route('settings/profile', 'settings.profile')->name('profile.edit');
    Volt::route('settings/password', 'settings.password')->name('user-password.edit');
    Volt::route('settings/appearance', 'settings.appearance')->name('appearance.edit');

    Volt::route('settings/two-factor', 'settings.two-factor')
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});

Route::get('/sub-departments/template', function () {
    return Excel::download(new SubDepartmentsTemplateExport, 'sub_departments_template.xlsx');
})->name('subdepartments.template');

Route::middleware(['auth'])->prefix('admin/')->name('admin.')->group(function () {
    Route::get('users', UserList::class)->name('users.index');
    Route::get('users/roles', RoleManager::class)->name('roles.index');
    Route::get('users/permissions', PermissionManager::class)->name('permissions.index');
    Route::get('departments', DepartmentManager::class)->name('departments.index');
    Route::get('sub-departments', SubDepartmentManager::class)->name('subdepartments.index');
    Route::get('positions', PositionManager::class)->name('positions.index');

});