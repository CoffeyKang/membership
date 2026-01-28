<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('dashboard', function () {
    return view('dashboard');
})
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::get('profile', function () {
    return view('profile');
})
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::get('members', function () {
    return view('members.index');
})
    ->middleware(['auth'])
    ->name('members.index');

Route::get('members/create', \App\Livewire\MemberForm::class)
    ->middleware(['auth'])
    ->name('members.create');

Route::get('members/{member}', function (\App\Models\Member $member) {
    return view('members.show', compact('member'));
})
    ->middleware(['auth'])
    ->name('members.show');

Route::get('members/edit/{member}', \App\Livewire\MemberForm::class)
    ->middleware(['auth'])
    ->name('members.edit');

Route::get('staff', function () {
    return view('staff.index');
})
    ->middleware(['auth'])
    ->name('staff.index');

Route::get('staff/create', function() {
    return view('staff.show', ['staff' => new \App\Models\Staff()]);
})->name('staff.create');


Route::get('staff/{staff}', function(\App\Models\Staff $staff){
    return view('staff.show', compact('staff'));
})
    ->middleware(['auth'])
    ->name('staff.show');

    
Route::get('staff-management', function () {
    return view('staff.management.index');
})
    ->middleware(['auth'])
    ->name('staff-management.index');

Route::get('staff/{staff}/payout', function(\App\Models\Staff $staff){
    return view('staff.management.payout', compact('staff'));
})
    ->middleware(['auth'])
    ->name('staff.management.payout');

Route::get('staff/{staff}/transactions', function(\App\Models\Staff $staff){
        return view('staff.management.transactions', compact('staff'));
    })
    ->middleware(['auth'])
    ->name('staff.management.transactions');

Route::get('reports/transactions', function () {
    return view('reports.transactions');
})
    ->middleware(['auth'])
    ->name('reports.transactions');
