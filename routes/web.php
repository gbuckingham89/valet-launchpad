<?php

use App\Http\Controllers\Web;
use Illuminate\Support\Facades\Route;

// Dashboard
Route::get('/', [Web\DashboardController::class, 'getIndex'])
    ->name('dashboard.index');
