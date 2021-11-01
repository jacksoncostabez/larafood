<?php

use Illuminate\Support\Facades\Route;

Route::prefix('admin')->group(function () {

    /**
     * Routes Permissions
     */
    Route::any('permissions/search', 'App\Http\Controllers\Admin\ACL\PermissionController@search')->name('permissions.search');
    Route::resource('permissions', 'App\Http\Controllers\Admin\ACL\PermissionController');

    /**
     * Routes Profiles
     */
    Route::any('profiles/search', 'App\Http\Controllers\Admin\ACL\ProfileController@search')->name('profiles.search');
    Route::resource('profiles', 'App\Http\Controllers\Admin\ACL\ProfileController');

    /**
     * Routes Details Plans
     */
    Route::get('plans/{url}/details/create', 'App\Http\Controllers\Admin\DetailPlanController@create')->name('details.plan.create');
    Route::get('plans/{url}/details/{idDetail}', 'App\Http\Controllers\Admin\DetailPlanController@show')->name('details.plan.show');
    Route::delete('plans/{url}/details/{idDetail}', 'App\Http\Controllers\Admin\DetailPlanController@destroy')->name('details.plan.destroy');
    Route::put('plans/{url}/details/{idDetail}', 'App\Http\Controllers\Admin\DetailPlanController@update')->name('details.plan.update');
    Route::get('plans/{url}/details/{idDetail}/edit', 'App\Http\Controllers\Admin\DetailPlanController@edit')->name('details.plan.edit');
    Route::post('plans/{url}/details', 'App\Http\Controllers\Admin\DetailPlanController@store')->name('details.plan.store');
    Route::get('plans/{url}/details', 'App\Http\Controllers\Admin\DetailPlanController@index')->name('details.plan.index');

    /**
     * Routes Plans
     */
    Route::get('/plans/create', 'App\Http\Controllers\Admin\PlanController@create')->name('plans.create');
    Route::any('/plans/search', 'App\Http\Controllers\Admin\PlanController@search')->name('plans.search');
    Route::delete('/plans/{url}', 'App\Http\Controllers\Admin\PlanController@destroy')->name('plans.destroy');
    Route::get('/plans/{url}/edit', 'App\Http\Controllers\Admin\PlanController@edit')->name('plans.edit');
    Route::put('/plans/{url}', 'App\Http\Controllers\Admin\PlanController@update')->name('plans.update');
    Route::get('/plans/{url}', 'App\Http\Controllers\Admin\PlanController@show')->name('plans.show');
    Route::post('/plans', 'App\Http\Controllers\Admin\PlanController@store')->name('plans.store');
    Route::get('/plans', 'App\Http\Controllers\Admin\PlanController@index')->name('plans.index');

    /**
     * Home Dashboard
     */
    Route::get('/', 'App\Http\Controllers\Admin\PlanController@index')->name('admin.index');
});

Route::get('/', function () {
    return view('welcome');
});
