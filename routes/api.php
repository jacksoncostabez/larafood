<?php

Route::get('/tenants/{uuid}', 'App\Http\Controllers\Api\TenantApiController@show');
Route::get('/tenants', 'App\Http\Controllers\Api\TenantApiController@index');

Route::get('/categories/{url}', 'App\Http\Controllers\Api\CategoryApiController@show');
Route::get('/categories', 'App\Http\Controllers\Api\CategoryApiController@categoriesByTenant');
