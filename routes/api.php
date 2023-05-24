<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ServiceController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/***
 * API routes for CRUD operations above clients.
 */
Route::get('/clients', [ClientController::class, 'index']);

Route::post('/clients', [ClientController::class, 'store']);

Route::get('/clients/{client}', [ClientController::class, 'show']);

Route::get('/clients/{client}/edit', [ClientController::class, 'edit']);

Route::put('/clients/{client}/edit', [ClientController::class, 'update']);

Route::delete('/clients/{client}/delete', [ClientController::class, 'destroy']);

/**
 * API routes for CRUD operations above services.
 */
Route::get('/services', [ServiceController::class, 'index']);

Route::post('/services', [ServiceController::class, 'store']);

Route::get('/services/{service}', [ServiceController::class, 'show']);

Route::get('/services/{service}/edit', [ServiceController::class, 'edit']);

Route::put('/services/{service}/edit', [ServiceController::class, 'update']);

Route::delete('/services/{service}/delete', [ServiceController::class, 'destroy']);


/**
 * Operations for attach/detach services to clients.
 */
Route::post('/clients/service', [ClientController::class, 'attach']);
Route::post('/clients/service/detach', [ClientController::class, 'detach']);


// Operation for getting the list of clients that have contracted a service.
Route::get('/services/{service}/clients', [ServiceController::class, 'clients']);
