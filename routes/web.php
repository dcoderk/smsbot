<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;

Route::get('/', function () {
    return view('welcome');
});


// These routes are now PUBLIC and do not require a login.
Route::get('/commands/sms', [CommandController::class, 'showTestForm'])->name('commands.sms.show');
Route::post('/commands/sms', [CommandController::class, 'executeTestCommand'])->name('commands.sms.execute');


// This group remains PROTECTED for Admins/Managers ONLY.
Route::middleware(['auth', 'is.superadmin'])->group(function () {
    Route::get('/commands/create', [CommandController::class, 'create'])->name('commands.create');
    Route::post('/commands', [CommandController::class, 'store'])->name('commands.store');
});

