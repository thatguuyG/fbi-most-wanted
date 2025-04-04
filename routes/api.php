<?php

use App\Http\Controllers\MostWantedApi;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API DOC Routes
|--------------------------------------------------------------------------
|
*/

Route::get('/wanted', [MostWantedApi::class, 'handle']);
