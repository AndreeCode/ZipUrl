<?php

use App\Http\Controllers\API\UrlController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

route::get('showUrls',[UrlController::class,'showAll']);
Route::post('urls',[UrlController::class,'store']);

Route::put('/urls',[UrlController::class,'update']);
Route::delete('/{ShortUrl}',[UrlController::class,'destroy']);

