<?php

use App\Http\Controllers\RegionController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();
Route::get('index', [RegionController::class, 'index'])->name('index');
Route::post('index/store', [RegionController::class, 'store'])->name('index.store');
