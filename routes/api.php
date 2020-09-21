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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'UsersControllers@index');
        Route::post('/', 'UsersControllers@store');
        Route::get('/{id}', 'UsersControllers@show');
        Route::delete('/{id}', 'UsersControllers@destroy');
        Route::post('/{id}', 'UsersControllers@update');
        Route::get('/role/role', 'RoleUserController@getRoleByUser');

    
    });
    Route::group(['prefix' => 'teams'], function () {
        Route::get('/', 'TeamsController@index');
        Route::post('/', 'TeamsController@store');
        Route::get('/{id}', 'TeamsController@show');
        Route::delete('/{id}', 'TeamsController@destroy');
        Route::post('/{id}', 'TeamsController@update');
    
    });
    Route::group(['prefix' => 'assign'], function () {
        Route::post('/', 'RolesController@test');
    });
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'RolesController@getRoles');
        Route::get('/permissions', 'RolesController@getPermissions');
        Route::post('/', 'RolesController@createRole');
        Route::post('/', 'RoleController@store');
        Route::post('/permissions', 'RolesController@createPermission');
        Route::get('/{id}', 'RolesController@findRole');
        Route::get('/permission/{id}', 'RolesController@findfindPermission');
        Route::delete('/{id}', 'RolesController@destroyRole');
        Route::delete('/permission/{id}', 'RolesController@destroyPermission');
        Route::post('/{id}', 'RolesController@updateRole');
        Route::post('/permission/{id}', 'RolesController@updatePermission');
        Route::post('/attachtoRole/{rid}/{pid}', 'RolesController@attachPermissionToRole');
        Route::match(['post', 'put'], '/sync_user_abilities/{id}', 'RolesController@syncAbilities');
    
    });

    /** Routes pour le Module de gestion de produit */

    /*Client*/
    Route::group(['prefix' => 'clients'], function () {
        Route::get('/', 'ClientController@index');
        Route::post('/', 'ClientController@store');
        Route::get('/{id}', 'ClientController@show');
        Route::match(['post', 'put'],'/{id}', 'ClientController@update');
        Route::delete('/{id}', 'ClientController@destroy');

    });

    /* Produit */
    Route::group(['prefix' => 'produits'], function () {
        Route::get('/', 'ProduitController@index');
        Route::post('/', 'ProduitController@store');
        Route::get('/{id}', 'ProduitController@show');
        Route::match(['post', 'put'],'/{id}', 'ProduitController@update');
        Route::delete('/{id}', 'ProduitController@destroy');

    });

    Route::group(['prefix' => 'commandes'], function () {
        Route::get('/{id}', 'CommandeController@getProductByClient');
        Route::get('/', 'CommandeController@getClientBuy');

    });
