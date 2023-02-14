<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::get('/', function () {
    return view('welcome');
});

Route::get('/users', [UserController::class, 'get_users']);

Route::group(['prefix' => 'user'], function () {
    Route::post('/create', [UserController::class, 'create_user']);
    Route::put('/update',[UserController::class, 'update']);
    Route::get('/{id}', [UserController::class, 'get_user_by_id']);
    Route::delete('/delete', [UserController::class, 'delete_user']);
});
