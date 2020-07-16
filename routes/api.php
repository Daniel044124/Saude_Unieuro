<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Profile;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items/all', 'ItemsController@getAll');

Route::resources([
    'roles' => 'RolesController',
    'items' => 'ItemsController',
    'menus' => 'MenusController',
    'users' => 'UsersController',
    'orders' => 'OrdersController'
]);
