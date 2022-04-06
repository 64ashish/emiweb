<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleContorller;
use App\Http\Controllers\Admin\UserController;
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

//    Route::resource('/organizations', OrganizationController::class)
//        ->middleware(['auth', 'isActive']);

    Route::middleware(['auth', 'role:admin', 'isAdmin', 'isActive'])
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

            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('users.edit');

            Route::resource('/categories', CategoryController::class);

            Route::resource('categories.archives', ArchiveController::class,
            ['except' => ['index']]);

            Route::get('/archives/', [ArchiveController::class, 'index'])
                ->name('archives.index');

            Route::get('/archives/{archive}/show', [ArchiveController::class, 'show'])
                ->name('archives.show');

            Route::get('/archives/{archive}/edit', [ArchiveController::class, 'edit'])
                ->name('archives.edit');

            Route::resource('/organizations', OrganizationController::class);
            Route::post('/organizations/{organization}/archive', [OrganizationController::class, 'syncArchive'])
                ->name('organization.archive.sync');
        });
