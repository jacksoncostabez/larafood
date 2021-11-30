<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')
    //->namespace('Admin')
    ->middleware('auth')
    ->group(function () {

        /*
        Route::get('teste-acl', function(){
            dd(auth()->user()->permissionsRole());
        });
        */

        /**
         * Roles x User
         */
        Route::get('roles/{idRole}/users/{idUser}/detach', 'App\Http\Controllers\Admin\ACL\RoleUserController@detachUserRole')->name('roles.users.detach');
        Route::post('roles/{id}/users', 'App\Http\Controllers\Admin\ACL\RoleUserController@attachUsersRole')->name('roles.users.attach');
        Route::any('roles/{id}/users/create', 'App\Http\Controllers\Admin\ACL\RoleUserController@usersAvailable')->name('roles.users.available');
        Route::get('roles/{id}/users', 'App\Http\Controllers\Admin\ACL\RoleUserController@roles')->name('roles.users');
        Route::get('users/{id}/roles', 'App\Http\Controllers\Admin\ACL\RoleUserController@users')->name('users.roles');
        
        /**
         * Roles x Users (Especializa TI)
         */
        Route::get('users/{id}/roles/{idRole}/detach', 'App\Http\Controllers\Admin\ACL\RoleUserController@detachRoleUser')->name('users.roles.detach');
        Route::post('users/{id}/roles', 'App\Http\Controllers\Admin\ACL\RoleUserController@attachRolesUser')->name('users.roles.attach');
        Route::any('users/{id}/roles/create', 'App\Http\Controllers\Admin\ACL\RoleUserController@rolesAvailable')->name('users.roles.available');
        Route::get('users/{id}/roles', 'App\Http\Controllers\Admin\ACL\RoleUserController@roles')->name('users.roles');
        Route::get('roles/{id}/users', 'App\Http\Controllers\Admin\ACL\RoleUserController@users')->name('roles.users');

        /**
         * Roles x Permissions
         */
        Route::get('roles/{id}/permissions', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@permissions')->name('roles.permissions');
        
        /**
         * Permission x Role
         */
        Route::get('roles/{id}/permission/{idPermission}/detach', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@detachPermissionRole')->name('roles.permission.detach');
        Route::post('roles/{id}/permissions', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@attachPermissionsRole')->name('roles.permissions.attach');
        Route::any('roles/{id}/permissions/create', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@permissionsAvailable')->name('roles.permissions.available');
        Route::get('roles/{id}/permissions', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@permissions')->name('roles.permissions');
        Route::get('permissions/{id}/roles', 'App\Http\Controllers\Admin\ACL\PermissionRoleController@roles')->name('permissions.roles');

        /**
         * Routes Roles
         */
        Route::any('roles/search', 'App\Http\Controllers\Admin\ACL\RoleController@search')->name('roles.search');
        Route::resource('roles', 'App\Http\Controllers\Admin\ACL\RoleController');

        /**
         * Tenants x Users
         */
        Route::get('tenants/{id}/users/create', 'App\Http\Controllers\Admin\TenantUserController@create')->name('tenants.users.create');
        Route::delete('tenants/{idTenant}/users/{idUser}', 'App\Http\Controllers\Admin\TenantUserController@destroy')->name('tenants.users.destroy');
        Route::put('tenants/{idTenant}/users/{idUser}', 'App\Http\Controllers\Admin\TenantUserController@update')->name('tenants.users.update');
        Route::get('tenants/{idTenant}/users/{idUser}/edit', 'App\Http\Controllers\Admin\TenantUserController@edit')->name('tenants.users.edit');
        Route::get('tenants/{id}/users', 'App\Http\Controllers\Admin\TenantUserController@users')->name('tenants.users');
        Route::post('tenants/{id}/users', 'App\Http\Controllers\Admin\TenantUserController@store')->name('tenants.users.store');
        

        /**
         * Routes Tenants
         */
        Route::any('tenants/search', 'App\Http\Controllers\Admin\TenantController@search')->name('tenants.search');
        Route::resource('tenants', 'App\Http\Controllers\Admin\TenantController');

        /**
         * Routes Tables
         */
        Route::any('tables/qrcode/{identify}', 'App\Http\Controllers\Admin\TableController@qrcode')->name('tables.qrcode');

        Route::any('tables/search', 'App\Http\Controllers\Admin\TableController@search')->name('tables.search');
        Route::resource('tables', 'App\Http\Controllers\Admin\TableController');

        /**
         * Products x Categories
         */
        Route::get('products/{id}/categories', 'App\Http\Controllers\Admin\CategoryProductController@categories')->name('products.categories');

        /**
         * Categories x Product
         */
        Route::get('products/{id}categories/{idCategory}/detach', 'App\Http\Controllers\Admin\CategoryProductController@detachCategoryProduct')->name('products.categories.detach');
        Route::post('products/{id}categories', 'App\Http\Controllers\Admin\CategoryProductController@attachCategoriesProduct')->name('products.categories.attach');
        Route::any('products/{id}categories/create', 'App\Http\Controllers\Admin\CategoryProductController@categoriesAvailable')->name('products.categories.available');
        Route::get('categories/{id}/products', 'App\Http\Controllers\Admin\CategoryProductController@products')->name('categories.products');

        /**
         * Routes Products
         */
        Route::any('products/search', 'App\Http\Controllers\Admin\ProductController@search')->name('products.search');
        Route::resource('products', 'App\Http\Controllers\Admin\ProductController');

        /**
         * Routes Categories
         */
        Route::any('categories/search', 'App\Http\Controllers\Admin\CategoryController@search')->name('categories.search');
        Route::resource('categories', 'App\Http\Controllers\Admin\CategoryController');

        /**
         * Routes Users
         */
        Route::any('users/search', 'App\Http\Controllers\Admin\UserController@search')->name('users.search');
        Route::resource('users', 'App\Http\Controllers\Admin\UserController');

        /**
         * Plan x Profile
         */
        Route::get('plans/{id}/profile/{idProfile}/detach', 'App\Http\Controllers\Admin\ACL\PlanProfileController@detachPlanProfile')->name('plans.profile.detach');
        Route::post('plans/{id}/profiles', 'App\Http\Controllers\Admin\ACL\PlanProfileController@attachProfilesPlan')->name('plans.profiles.attach');
        Route::any('plans/{id}/profiles/create', 'App\Http\Controllers\Admin\ACL\PlanProfileController@profilesAvailable')->name('plans.profiles.available');
        Route::get('plans/{id}/profiles', 'App\Http\Controllers\Admin\ACL\PlanProfileController@profiles')->name('plans.profiles');
        Route::get('profiles/{id}/plans', 'App\Http\Controllers\Admin\ACL\PlanProfileController@plans')->name('profiles.plans');

        /**
         * Profiles x Permissions
         */
        Route::get('profiles/{id}/permissions', 'App\Http\Controllers\Admin\ACL\PermissionProfileController@permissions')->name('profiles.permissions');

        /**
         * Permission x Profile
         */
        Route::get('profiles/{id}/permission/{idPermission}/detach', 'App\Http\Controllers\Admin\ACL\PermissionProfileController@detachPermissionProfile')->name('profiles.permission.detach');
        Route::post('profiles/{id}/permissions', 'App\Http\Controllers\Admin\ACL\PermissionProfileController@attachPermissionsProfile')->name('profiles.permissions.attach');
        Route::any('profiles/{id}/permissions/create', 'App\Http\Controllers\Admin\ACL\PermissionProfileController@permissionsAvailable')->name('profiles.permissions.available');
        Route::get('permissions/{id}/profiles', 'App\Http\Controllers\Admin\ACL\PermissionProfileController@profiles')->name('permissions.profiles');

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
        Route::get('/', 'App\Http\Controllers\Admin\DashBoardController@home')->name('admin.index');
        //Route::get('/', 'App\Http\Controllers\Admin\PlanController@index')->name('admin.index');
    });

/*
Route::get('/', function () {
    return view('welcome');
}); */

/**
 * Site
 */
Route::get('/plan/{url}', 'App\Http\Controllers\Site\SiteController@plan')->name('plan.subscription');
Route::get('/', 'App\Http\Controllers\Site\SiteController@index')->name('site.home');


/**
 * Auth Routes
 */
Auth::routes();
