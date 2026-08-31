<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return redirect('/countries');
});

Route::resource('countries', CountryController::class);
Route::resource('states', StateController::class);
Route::resource('cities', CityController::class);

Route::get('/countries/export', [CountryController::class, 'export'])
    ->name('countries.export');

Route::get('/states/by-country/{country}', [StateController::class, 'byCountry'])
    ->name('states.byCountry');
