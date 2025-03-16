<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PokedexController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Define a GET endpoint
Route::get('/real-estate', [PokedexController::class, 'index']);

Route::get('/real-estate/{name}', [PokedexController::class, 'show']);

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
