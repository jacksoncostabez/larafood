<?php


Route::get('/tenants/{uuid}', 'App\Http\Controllers\Api\TenantApiController@show');
Route::get('/tenants', 'App\Http\Controllers\Api\TenantApiController@index');