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
use App\Livewire\Admin\Recruitment\CandidateForm;
use App\Livewire\Admin\Recruitment\CandidateManager;
use App\Livewire\Admin\Recruitment\CandidateView;
use App\Livewire\Admin\Recruitment\CandidateShortlist;

use App\Livewire\Frontend\CandidateApplication;
use App\Livewire\Frontend\HomePage;
use App\Livewire\Frontend\CandidateSuccess;

/*
Route::get('/', function () {
    return view('welcome');
})->name('home');

*/

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
    Route::get('candidate-form', CandidateForm::class)->name('candidate.form');
    Route::get('candidates', CandidateManager::class)->name('candidates.index');
    Route::get('candidates/{id}/view', CandidateView::class)->name('candidates.view');
    Route::get('candidates/shortlist', CandidateShortlist::class)->name('shortlists.view');


});


Route::get('/', HomePage::class)->name('home');
Route::get('/apply', CandidateApplication::class)->name('frontend.candidate.apply');


Route::get('/application-success/{id}', CandidateSuccess::class)->name('candidate.success');
