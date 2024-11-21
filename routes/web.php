<?php

use App\Http\Controllers\WelcomeController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'welcome'])->name('welcome');

Route::get('/home', function () {
    return view('home');
})->name('home');


Route::get('/inventory', function () {
    return view('inventory');
})->name('inventory');

Route::get('/employee_progress_main', function () {
    return view('employee_progress_main');
})->name('employee_progress_main');


Route::get('/material_usage', function () {
    return view('material_usage');
})->name('material_usage');


Route::get('/profile', function () {
    return view('profile');
})->name('profile');

Route::post('/logout', function () {
    // Add logout logic here when implementing authentication
    return redirect('/');
})->name('logout');




