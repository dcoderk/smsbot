<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;

Route::get('/', function () {
    return view('welcome');
});


// These routes are now PUBLIC and do not require a login.
Route::get('/commands/test', [CommandController::class, 'showTestForm'])->name('commands.test.show');
Route::post('/commands/test', [CommandController::class, 'executeTestCommand'])->name('commands.test.execute');


// This group remains PROTECTED for Admins/Managers ONLY.
Route::middleware(['auth', 'is.superadmin'])->group(function () {
    Route::get('/commands/create', [CommandController::class, 'create'])->name('commands.create');
    Route::post('/commands', [CommandController::class, 'store'])->name('commands.store');
});

