<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\CityController;

Route::get('/', function () {
    return redirect('/countries');
});

Route::resource('countries', CountryController::class)->only(['index','create','store']);
Route::resource('cities', CityController::class)->only(['index','create','store']);