<?php

use App\Models\Client;

/**
 * Clientes
 */
Route::post('/auth/register', 'App\Http\Controllers\Api\Auth\RegisterController@store');
Route::post('/auth/token', 'App\Http\Controllers\Api\Auth\AuthClientController@auth');

/**
 * Usuários autenticados
 */
Route::group([
    'middleware' => ['auth:sanctum']
], function () {
    Route::get('/auth/me', 'App\Http\Controllers\Api\Auth\AuthClientController@me');
    Route::post('/auth/logout', 'App\Http\Controllers\Api\Auth\AuthClientController@logout');

    Route::post('/auth/v1/orders/{identifyOrder}/evaluations', 'App\Http\Controllers\Api\EvaluationApiController@store');

    Route::get('/auth/v1/my-orders', 'App\Http\Controllers\Api\OrderApiController@myOrders');
    Route::post('/auth/v1/orders', 'App\Http\Controllers\Api\OrderApiController@store');
});

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api'
], function () {
    Route::get('/tenants/{uuid}', 'TenantApiController@show');
    Route::get('/tenants', 'TenantApiController@index');

    Route::get('/categories/{identify}', 'CategoryApiController@show');
    Route::get('/categories', 'CategoryApiController@categoriesByTenant');

    Route::get('/tables/{identify}', 'TableApiController@show');
    Route::get('/tables', 'TableApiController@tablesByTenant');

    Route::get('/products/{identify}', 'ProductApiController@show');
    Route::get('/products', 'ProductApiController@productsByTenant');

    Route::post('/orders', 'OrderApiController@store');
    Route::get('/orders/{identify}', 'OrderApiController@show');
});
