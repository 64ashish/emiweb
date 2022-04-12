<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleContorller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Emiweb\HomeController;
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

    Route::middleware(['auth', 'role:super admin', 'isAdmin', 'isActive'])
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
            Route::post('/users/{user}/sync-role', [UserController::class, 'syncRole'])
                ->name('users.sync-role');

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
                ->name('organizations.archive.sync');

            Route::post('/organizations/{organization}/users/search', [UserController::class, 'search'])
            ->name('organizations.users.search');

            Route::post('/organizations/{organization}/users/{user}/sync-user', [UserController::class, 'syncWithOrganization'])
                ->name('organizations.users.sync');
        });



//    emiweb office urls
    Route::middleware(['auth', 'role:super admin|emiweb admin|emiweb staff',  'isActive'])
        ->name('emiweb.')
        ->prefix('emiweb')
        ->group(function(){
            Route::get('/', [HomeController::class, 'index'])->name('index'); // get to emiweb dashboard
//            categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index'); // show all categories
            Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show'); // show one categories
//            Archives
            Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index'); // show all categories
            Route::get('/archives/{archive}', [ArchiveController::class, 'show'])->name('archives.show'); // show one categories


            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');

            Route::post('/users/{user}/sync-role', [UserController::class, 'syncRole'])
                ->name('users.sync-role');

//            organization stuff
            Route::resource('/organizations', OrganizationController::class);
            Route::post('/organizations/{organization}/archive', [OrganizationController::class, 'syncArchive'])
                ->name('organizations.archive.sync');
//
            Route::post('/organizations/{organization}/users/search', [UserController::class, 'search'])
                ->name('organizations.users.search');      // search user

            Route::post('/organizations/{organization}/users/{user}/sync-user', [UserController::class, 'syncWithOrganization'])
                ->name('organizations.users.sync');      // sync user to organization
        });
