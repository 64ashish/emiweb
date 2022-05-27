<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleContorller;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Record\DalslanningarBornInAmericaRecordController;
use App\Http\Controllers\Record\DenmarkEmigrationController;
use App\Http\Controllers\Record\SwedishChurchEmigrationRecordController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\OrganizationArchiveController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\UserOrganizationController;
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
    Route::middleware(['auth','isActive'])->get('/home', [HomeController::class,'index'])
    ->name('home');
    Route::middleware(['auth','isActive'])->post('/language', [HomeController::class,'localSwitcher'])
    ->name('local');





// super user urls
    Route::middleware(['auth', 'role:super admin|emiweb admin|emiweb staff',  'isActive'])
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
            Route::put('/users/{user}/update', [UserController::class, 'update'])
                ->name('users.update');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('users.edit');
            Route::post('/users/{user}/sync-role', [UserController::class, 'syncRole'])
                ->name('users.sync-role');
//            Route::post('/users/{user}/impersonate', [UserController::class, 'impersonate']);
//            Route::get('/leave-impersonate', 'UsersController@leaveImpersonate')
//                ->name('users.leave-impersonate');

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
            Route::get('/', [AdminController::class, 'index'])->name('index'); // get to emiweb dashboard
//            categories
            Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index'); // show all categories
            Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show'); // show one categories
//            Archives
            Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index'); // show all categories
            Route::get('/archives/{archive}', [ArchiveController::class, 'show'])->name('archives.show'); // show one categories


            Route::get('/users', [UserController::class, 'index'])
                ->name('users.index');

            Route::put('/users/{user}/update', [UserController::class, 'update'])
                ->name('users.update');
            Route::get('/users/{user}/edit', [UserController::class, 'edit'])
                ->name('users.edit');

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

//    organization users
Route::middleware(['auth', 'role:super admin|emiweb admin|emiweb staff|organization admin|organization staff',  'isActive'])
    ->group(function(){
        Route::get('/dashboard', [DashboardController::class,'index'])
        ->name('dashboard');

        // export archive records
        Route::get('archives/{archive}/export', [ExportController::class, 'exportToFile'])
            ->name('archives.export');
//        Import archive records
        Route::post('archives/{archive}/import', [ImportController::class, 'importFromFile'])
            ->name('archives.import');

        Route::resource('/organizations', UserOrganizationController::class, ['only' => ['show','update']]);

//        show user association table
        Route::get('/organizations/{organization}/users/associations', [StaffController::class, 'associations'])
            ->name('organizations.users.associations');

//        show edit form
        Route::get('/organizations/{organization}/users/{user}', [StaffController::class, 'edit'])
            ->name('organizations.users.edit');
//        save updated details
        Route::put('/users/{user}/update', [StaffController::class, 'update'])
            ->name('users.update');
//
        Route::post('/organizations/{organization}/users/{user}/approve-association', [StaffController::class, 'approveAssociation'])
            ->name('organizations.users.approve-association');      // approve or reject association

        Route::post('/organizations/{organization}/users/{user}/sync-user', [StaffController::class, 'syncWithOrganization'])
            ->name('organizations.users.sync');      // sync user to organization

        Route::post('/users/{user}/sync-role', [StaffController::class, 'syncRole'])
            ->name('users.sync-role');

        // show all record for specific archive
        Route::get('/organization/{organization}/archives/{archive}/records', [OrganizationArchiveController::class, 'ShowRecords'])
            ->name('organizations.archives.records');
        //        show create new record on specific archive
        Route::get('/organization/{organization}/archives/{archive}/records/create', [OrganizationArchiveController::class, 'create'])
            ->name('organizations.archives.records.create');
        //        create new record on specific archive
        Route::post('/organization/{organization}/archives/{archive}/records', [OrganizationArchiveController::class, 'store'])
            ->name('organizations.archives.records.store');
        // show specific record
        Route::get('/organization/{organization}/archives/{archive}/records/{id}', [OrganizationArchiveController::class, 'view'])
            ->name('organizations.archives.show');
        Route::get('/organization/{organization}/archives/{archive}/records/{record}/edit', [OrganizationArchiveController::class, 'edit'])
            ->name('organizations.archives.record.edit');
        Route::put('/organization/{organization}/archives/{archive}/records/{record}/update', [OrganizationArchiveController::class, 'update'])
            ->name('organizations.archives.record.update');




    });



//regular users and subscribers
Route::middleware(['auth', 'role:super admin|emiweb admin|emiweb staff|organization admin|organization staff|regular user|subscriber',  'isActive'])
    ->group(function(){
        Route::get('/home/users/{user}', [HomeController::class, 'user'])
        ->name('home.users.edit');
        Route::put('/home/users/{user}', [HomeController::class, 'updateUser'])
        ->name('home.users.update');
        Route::post('/search', [SearchController::class, 'search'])
            ->name('search');
        Route::get('SwedishChurchEmigrationRecord/', [SwedishChurchEmigrationRecordController::class, 'index'])
            ->name('swedishchurchemigration');
//        Route::get('SwedishChurchEmigrationRecord/{SwedishChurchEmigrationRecord}', [SwedishChurchEmigrationRecordController::class, 'show']);
        Route::get('/records/{archive}', [SearchController::class, 'index'])
            ->name('records');
        Route::get('/records/{arch}/{id}', [SearchController::class, 'show'])
            ->name('records.show');

        // denmark emigration stuff
        Route::get('/danishemigration/show/{id}', [DenmarkEmigrationController::class, 'show'])
            ->name('danishemigration.show');
        Route::match(['get', 'post'],'/danishemigration/search', [DenmarkEmigrationController::class, 'search'])->name('danishemigration.search');


//        DalslanningarBornInAmericaRecord

        Route::get('/dbir/show/{id}', [DalslanningarBornInAmericaRecordController::class, 'show'])
            ->name('dbir.show');
        Route::match(['get', 'post'],'/dbir/search', [DalslanningarBornInAmericaRecordController::class, 'search'])->name('dbir.search');



    });
