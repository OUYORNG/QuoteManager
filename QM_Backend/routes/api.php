<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuoteController;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/register', [AuthController::class, 'getUser']);

Route::prefix('quotes')->group(function(){
    Route::post('/', [QuoteController::class,'SaveQuote']);
    Route::get('/', [QuoteController::class,'getFavoriteQuotes']);
    Route::delete('/{id}', [QuoteController::class,'DeleteQuoteByID']);
    Route::get('/random',[QuoteController::class, 'getRandomQuote']);
});



