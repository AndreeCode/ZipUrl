<?php

use App\Http\Controllers\API\UrlController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/{shortUrl}',[UrlController::class,'show'])->where('shortUrl', '[a-zA-Z0-9]+');