<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GamesController;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\adminOnly;

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

Route::get('/auth/apaja', function(Request $request){
    return response()->json(['message' => 'Unatuhicated'], 401);
})->name('login');


Route::group(['middleware' => ['checkAuth', 'auth:sanctum'], 'prefix' => 'v1'],function ($routes) {
    // Auth
    $routes->post('/auth/logout', [AuthController::class, 'logout']);
    
    // Games
    $routes->post('/games/create', [GamesController::class, 'create'])->middleware(adminOnly::class);
    $routes->get('/games', [GamesController::class, 'getAllGames']);
    $routes->get('/detail/games/{id}', [GamesController::class, 'detailGames']);
    
    // comments
    $routes->post('/comment', [CommentController::class, 'postComment']);
    $routes->get('/comment/{id}', [CommentController::class, 'getComment']);
    

});

Route::group(['prefix' => 'v1'], function($routes){
    $routes->post('/auth/login', [AuthController::class, 'login']);
    $routes->post('/auth/register', [AuthController::class, 'register']);
});

// Route::group()
