<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/login', 'LoginController@authenticate');
Route::get('/logout', 'LoginController@logout');

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/items/all', 'ItemsController@getAll');
    Route::get('/lots/item/{id}', 'LotsController@getByItems');
    Route::get('/user/{id}/orders', 'UsersController@orders');
    Route::put('/users/{id}/redefine', 'UsersController@redefinePassword');
    Route::put('/orders/dispatch/{id}', 'OrdersController@dispatchOrder');
    Route::put('/orders/processing/{order}', 'OrdersController@processingOrder');
    Route::get('/orders/{id}/items/lots', 'OrdersController@getOrdersItemsLots');
    Route::get('/roles/{id}/menus', 'RolesController@getMenusByRole');
    Route::put('/roles/{id}/menus', 'RolesController@setMenusByRole');
    Route::apiResources([
        'roles' => 'RolesController',
        'items' => 'ItemsController',
        'menus' => 'MenusController',
        'users' => 'UsersController',
        'orders' => 'OrdersController',
        'lots' => 'LotsController',
        'labs' => 'LabsController',
        'courses' => 'CoursesController'
    ]);
});

