<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommandController;

Route::get('/', function () {
    return view('welcome');
});


// This route will show the test page form
Route::get('/commands/test', [CommandController::class, 'showTestForm'])->name('commands.test.show');

// This route will handle the form submission
Route::post('/commands/test', [CommandController::class, 'executeTestCommand'])->name('commands.test.execute');