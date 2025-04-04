<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MostWantedApi;
use Spatie\ResponseCache\Middlewares\CacheResponse;

Route::get('api/wanted', [MostWantedApi::class, 'getData'])->middleware(CacheResponse::class);;


Route::view('/', 'welcome');
