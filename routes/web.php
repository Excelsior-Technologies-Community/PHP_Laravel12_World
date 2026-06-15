<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return redirect('/countries');
});

Route::resource('countries', CountryController::class)->only(['index', 'create', 'store']);
Route::resource('cities', CityController::class)->only(['index', 'create', 'store']);

// Delete Routes
Route::delete('/countries/{country}', [CountryController::class, 'destroy'])
    ->name('countries.destroy');

Route::delete('/cities/{city}', [CityController::class, 'destroy'])
    ->name('cities.destroy');

Route::get('/countries/export', [CountryController::class, 'export'])
    ->name('countries.export');