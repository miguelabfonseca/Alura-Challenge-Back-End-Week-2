<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiVideoController;
use App\Http\Controllers\CategoriasController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('categorias', CategoriasController::class);
Route::resource('videos', ApiVideoController::class);
Route::get('/categorias/{id}/videos', [CategoriasController::class, 'videos']);
#Route::get('/videos/?search={search}', [CategoriasController::class, 'procura']);
