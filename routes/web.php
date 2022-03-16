<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleContorller;
use App\Http\Controllers\Emiweb\OrganizationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

    Route::get('/', function () {
        return view('welcome');
    });


    Route::get('/dashboard', function () {
        return view('dashboard');
    })
    ->middleware(['auth'])
    ->name('dashboard');


    Route::resource('/organizations', OrganizationController::class)
        ->middleware(['auth']);

    Route::middleware(['auth', 'role:admin'])
        ->name('admin.')
        ->prefix('admin')
        ->group(function(){
            Route::get('/', [AdminController::class, 'index'])->name('index');
            Route::resource('/roles', RoleContorller::class);
            Route::post('/roles/{role}/permissions', [RoleContorller::class, 'updatePermission'])
                ->name('roles.permissions');
            Route::delete('/roles/{role}/permissions/{permission}', [RoleContorller::class, 'revokePermission'])
                ->name('roles.permissions.revoke');
            Route::resource('/permissions', PermissionController::class);
        });