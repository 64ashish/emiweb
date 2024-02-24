<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ArchiveController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ImageCollectionController;
use App\Http\Controllers\ImagesInArchiveController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\Record\BevaringensLevnadsbeskrivningarRecordController;
use App\Http\Controllers\Record\BrodernaLarssonArchiveRecordController;
use App\Http\Controllers\Record\DalslanningarBornInAmericaRecordController;
use App\Http\Controllers\Record\DenmarkEmigrationController;
use App\Http\Controllers\Record\IcelandEmigrationRecordController;
use App\Http\Controllers\Record\JohnEricssonsArchiveRecordController;
use App\Http\Controllers\Record\LarssonEmigrantPopularRecordController;
use App\Http\Controllers\Record\MormonShipPassengerRecordController;
use App\Http\Controllers\Record\NewYorkPassengerRecordController;
use App\Http\Controllers\Record\NorthenPacificRailwayCompanyRecordController;
use App\Http\Controllers\Record\NorwayEmigrationRecordController;
use App\Http\Controllers\Record\NorwegianChurchImmigrantRecordController;
use App\Http\Controllers\Record\ObituariesSweUsaNewspapersRecordController;
use App\Http\Controllers\Record\RsPersonalHistoryRecordController;
use App\Http\Controllers\Record\SwedeInAlaskaRecordController;
use App\Http\Controllers\Record\SwedishAmericanBookRecordController;
use App\Http\Controllers\Record\SwedishAmericanChurchArchiveRecordController;
use App\Http\Controllers\Record\SwedishAmericanJubileeRecordController;
use App\Http\Controllers\Record\SwedishAmericanMemberRecordController;
use App\Http\Controllers\Record\SwedishChurchEmigrationRecordController;
use App\Http\Controllers\Record\SwedishChurchImmigrantRecordController;
use App\Http\Controllers\Record\SwedishEmigrantViaKristianiaRecordController;
use App\Http\Controllers\Record\SwedishEmigrationStatisticsRecordController;
use App\Http\Controllers\Record\SwedishImmigrationStatisticsRecordController;
use App\Http\Controllers\Record\SwedishPortPassengerListRecordController;
use App\Http\Controllers\Record\SwedishUsaCentersEmiPhotoRecordController;
use App\Http\Controllers\Record\SwensonCenterPhotosamlingRecordController;
use App\Http\Controllers\Record\VarmlandskaNewspaperNoticeRecordController;
use App\Http\Controllers\RelativeController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SendEmailsController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\OrganizationArchiveController;
use App\Http\Controllers\User\StaffController;
use App\Http\Controllers\User\UserOrganizationController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Cashier\Subscription;
use Laravel\Fortify\Http\Controllers\AuthenticatedSessionController;
use App\Mail\WarningMail;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\AdminNewsController;

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

// Route to the index page
Route::get('/', [HomeController::class, 'index']);

// Routes for news with middleware for authentication, activity status, verification, and user home check
Route::middleware(['auth', 'isActive', 'verified', 'userIsHome'])->get('/news', [NewsController::class, 'index']);
Route::middleware(['auth', 'isActive', 'verified', 'userIsHome'])->get('/news/{id}', [NewsController::class, 'show'])->name('new.show');

//Route::get('/mail', [SendEmailsController::class, 'sendTest']);
//Route::get('/login', [AuthenticatedSessionController::class, 'create']);

// Route to the home page with middleware for authentication, activity status, verification, and user home check
Route::middleware(['auth', 'isActive', 'verified', 'userIsHome'])->get('/home', [HomeController::class, 'index'])->name('home');

// Route to switch language
Route::middleware(['web'])->post('/language', [HomeController::class, 'localSwitcher'])->name('local');

// Routes with group middleware for authentication
Route::group(['middleware' => ['auth']], function () {

    // Route to verify email with email verification request
    Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
        $request->fulfill();
        return redirect('/');
    })->middleware(['auth', 'signed'])->name('verification.verify');

    // Route to show email verification notice
    Route::get('/email/verify', function () {
        return view('auth.verify-email');
    })->middleware('auth')->name('verification.notice');

    // Route to send email verification notification
    Route::post('/email/verification-notification', function (Request $request) {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    })->middleware(['auth', 'throttle:6,1'])->name('verification.send');

    // Route to send mail
    Route::get('send-mail', [HomeController::class, 'mailSend'])->name('mailSend');

    // Route to check coupon
    Route::post('/checkCoupon', [UserController::class, 'checkCoupon'])->name('checkCoupon');

    // Route to process payment
    Route::post('/payment', [UserController::class, 'payment'])->name('payment');

    // Route to save payment details
    Route::post('/save-payment', [UserController::class, 'savepayment'])->name('savepayment');

    //    Route::get('/email/verify', 'VerificationController@show')->name('verification.notice');
    //    Route::get('/email/verify/{id}/{hash}', 'VerificationController@verify')->name('verification.verify')->middleware(['signed']);
    //    Route::post('/email/resend', 'VerificationController@resend')->name('verification.resend');

});

//Route::get('/billing-portal', function (Request $request) {
//    return auth()->user()->redirectToBillingPortal();
//});

//Route::post('/subscribe',function (Request $request){
////    dd($request->all());
//    auth()->user()->newSubscription('cashier', $request->plan)->quantity(5)->create($request->paymentMethod);
//
//    return "subscription created";
//});


// Middleware group for super user URLs with authentication, verification, roles, and activity status
Route::middleware(['auth', 'verified', 'role:super admin|emiweb admin|emiweb staff', 'isActive'])
    ->name('admin.') // Naming prefix for admin routes
    ->prefix('admin') // Prefix for admin routes
    ->group(function () {

        // Routes for managing news
        Route::get('news', [AdminNewsController::class, 'index'])->name('news.index');
        Route::post('news', [AdminNewsController::class, 'store'])->name('news.store');
        Route::get('news/create', [AdminNewsController::class, 'create'])->name('news.create');
        Route::get('news/edit/{id}', [AdminNewsController::class, 'edit'])->name('news.edit');
        Route::put('news/update/{id}', [AdminNewsController::class, 'update'])->name('news.update');
        Route::get('news/destroy/{id}', [AdminNewsController::class, 'destroy'])->name('news.destroy');

        // Resource routes for roles
        Route::resource('/roles', RoleController::class);
        Route::post('/roles/{role}/permissions', [RoleController::class, 'updatePermission'])->name('roles.permissions');
        Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');

        // Resource routes for permissions
        Route::resource('/permissions', PermissionController::class);

        // Routes for managing users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('/users/search', [UserController::class, 'searchForAdmin'])->name('users.search');
        Route::get('/users/search', [UserController::class, 'index'])->name('users.search');
        Route::post('/users/{user}/sync-role', [UserController::class, 'syncRole'])->name('users.sync-role');
        Route::post('/users/{user}/expire-plan', [UserController::class, 'expirePlan'])->name('users.expire-plan');

        // Resource routes for categories
        Route::resource('/categories', CategoryController::class);

        // Nested resource routes for archives within categories
        Route::resource('categories.archives', ArchiveController::class, ['except' => ['index']]);

        // Route to show all archives
        Route::get('/archives/', [ArchiveController::class, 'index'])->name('archives.index');

        // Route to show a specific archive
        Route::get('/archives/{archive}/show', [ArchiveController::class, 'show'])->name('archives.show');

        // Route to edit a specific archive
        Route::get('/archives/{archive}/edit', [ArchiveController::class, 'edit'])->name('archives.edit');

        // Route to update a specific archive
        Route::put('/archives/{archive}/update', [ArchiveController::class, 'update'])->name('archives.update');

        // Route to display archives
        Route::get('/archives/display', [ArchiveController::class, 'display'])->name('archives.display');

        // Resource routes for organizations
        Route::resource('/organizations', OrganizationController::class);
        Route::post('/organizations/{organization}/archive', [OrganizationController::class, 'syncArchive'])->name('organizations.archive.sync');
        Route::post('/organizations/{organization}/users/search', [UserController::class, 'search'])->name('organizations.users.search');
        Route::post('/organizations/{organization}/users/{user}/sync-user', [UserController::class, 'syncWithOrganization'])->name('organizations.users.sync');
    });

// Middleware group for emiweb office URLs with authentication, verification, roles, and activity status
Route::middleware(['auth', 'verified', 'role:super admin|emiweb admin|emiweb staff', 'isActive'])
    ->name('emiweb.') // Naming prefix for emiweb routes
    ->prefix('emiweb') // Prefix for emiweb routes
    ->group(function () {

        // Route to get to emiweb dashboard
        Route::get('/', [AdminController::class, 'index'])->name('index');

        // Route to show all categories
        Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');

        // Route to show one category
        Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');

        // Route to show all archives
        Route::get('/archives', [ArchiveController::class, 'index'])->name('archives.index');

        // Route to show one archive
        Route::get('/archives/{archive}', [ArchiveController::class, 'show'])->name('archives.show');

        // Route to show all users
        Route::get('/users', [UserController::class, 'index'])->name('users.index');

        // Route to update user
        Route::put('/users/{user}/update', [UserController::class, 'update'])->name('users.update');

        // Route to edit user
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');

        // Route to search for users by admin
        Route::post('/users/search', [UserController::class, 'searchForAdmin'])->name('users.search');

        // Route to sync user role
        Route::post('/users/{user}/sync-role', [UserController::class, 'syncRole'])->name('users.sync-role');

        // Route to list all subscribed users
        Route::get('/users/with-subscriptions', [UserController::class, 'subscribers'])->name('users.subscribers');

        // Route to cancel subscription for a user
        Route::get('/users/{user}/with-subscriptions/cancel', [UserController::class, 'subscriptionCancel'])->name('users.subscribers.cancel');

        // Route to resource for organizations
        Route::resource('/organizations', OrganizationController::class);

        // Route to sync archive to organization
        Route::post('/organizations/{organization}/archive', [OrganizationController::class, 'syncArchive'])->name('organizations.archive.sync');

        // Route to search for users within an organization
        Route::post('/organizations/{organization}/users/search', [UserController::class, 'search'])->name('organizations.users.search');

        // Route to sync user to organization
        Route::post('/organizations/{organization}/users/{user}/sync-user', [UserController::class, 'syncWithOrganization'])->name('organizations.users.sync');
    });

// Route group for organization users with middleware for authentication, verification, roles, and activity status
Route::middleware(['auth', 'verified', 'role:super admin|emiweb admin|emiweb staff|organization admin|organization staff', 'isActive'])
    ->group(function () {

        // Dashboard route
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // Export archive records
        Route::get('archives/{archive}/export', [ExportController::class, 'exportToFile'])
            ->name('archives.export');

        // Import archive records
        Route::post('archives/{archive}/import', [ImportController::class, 'importFromFile'])
            ->name('archives.import');

        // Resource routes for ImageCollections
        Route::resource('/ImageCollections', ImageCollectionController::class, ['except' => ['create', 'store']]);
        Route::get('archives/{archive}/ImageCollections', [ImageCollectionController::class, 'create'])
            ->name('ImageCollections.create');
        Route::post('archives/{archive}/ImageCollections', [ImageCollectionController::class, 'store'])
            ->name('ImageCollections.store');
        Route::post('/ImageCollections/{ImageCollection}/upload', [ImageCollectionController::class, 'upload'])
            ->name('ImageCollections.upload');

        // Resource routes for organizations
        Route::resource('/organizations', UserOrganizationController::class, ['only' => ['show', 'update']]);

        // Route to show user association table
        Route::get('/organizations/{organization}/users/associations', [StaffController::class, 'associations'])
            ->name('organizations.users.associations');

        // Route to show edit form for user
        Route::get('/organizations/{organization}/users/{user}', [StaffController::class, 'edit'])
            ->name('organizations.users.edit');

        // Route to save updated user details
        Route::put('/users/{user}/update', [StaffController::class, 'update'])
            ->name('users.update');

        // Route to approve or reject association
        Route::post('/organizations/{organization}/users/{user}/approve-association', [StaffController::class, 'approveAssociation'])
            ->name('organizations.users.approve-association');

        // Route to sync user to organization
        Route::post('/organizations/{organization}/users/{user}/sync-user', [StaffController::class, 'syncWithOrganization'])
            ->name('organizations.users.sync');

        // Route to sync user role
        Route::post('/users/{user}/sync-role', [StaffController::class, 'syncRole'])
            ->name('users.sync-role');

        // Route to show all records for a specific archive
        Route::get('/organization/{organization}/archives/{archive}/records', [OrganizationArchiveController::class, 'ShowRecords'])
            ->name('organizations.archives.records');

        // Route to show create new record for a specific archive
        Route::get('/organization/{organization}/archives/{archive}/records/create', [OrganizationArchiveController::class, 'create'])
            ->name('organizations.archives.records.create');

        // Route to create new record for a specific archive
        Route::post('/organization/{organization}/archives/{archive}/records', [OrganizationArchiveController::class, 'store'])
            ->name('organizations.archives.records.store');

        // Route to show specific record
        Route::get('/organization/{organization}/archives/{archive}/records/{id}', [OrganizationArchiveController::class, 'view'])
            ->name('organizations.archives.show');

        // Route to edit specific record
        Route::get('/organization/{organization}/archives/{archive}/records/{record}/edit', [OrganizationArchiveController::class, 'edit'])
            ->name('organizations.archives.record.edit');

        // Route to update specific record
        Route::put('/organization/{organization}/archives/{archive}/records/{record}/update', [OrganizationArchiveController::class, 'update'])
            ->name('organizations.archives.record.update');

        // Route to create image association to record
        Route::post('archives/{archive}/records/{id}/image/create', [ImagesInArchiveController::class, 'create'])
            ->name('record.image');

        // Route to create relatives
        Route::post('archives/{archive}/records/{id}/relatives/create', [RelativeController::class, 'create'])
            ->name('relatives.create');
    });


//regular users and subscribers
Route::middleware(['auth', 'verified', 'userIsHome', 'role:super admin|emiweb admin|emiweb staff|organization admin|organization staff|organizational subscriber|regular user|subscriber', 'isActive'])
->group(function () {

    // Routes for managing users in the home
    Route::get('/home/users/{user}',
        [HomeController::class, 'user']
    )->name('home.users.edit');
    Route::put('/home/users/{user}',
        [HomeController::class, 'updateUser']
    )->name('home.users.update');
    Route::put('/home/users/{user}/cancel_sub', [HomeController::class, 'endSubscription'])->name('home.users.endsubscription');
    Route::post('/home/users/cancelsub/{user}', [HomeController::class, 'cancelautosubc'])->name('home.users.cancelsub');

    // Route for search functionality
    Route::match(['get', 'post'], '/search', [SearchController::class, 'search'])->name('search');

    // Route for Swedish Church Emigration Records
    Route::get('SwedishChurchEmigrationRecord/', [SwedishChurchEmigrationRecordController::class, 'index'])->name('swedishchurchemigration');

    // Route for viewing records in an archive
    Route::get('/records/{archive}',
        [SearchController::class, 'index']
    )->name('records');

    // Route for showing a specific record in an archive
    Route::get('/records/{arch}/{id}', [SearchController::class, 'show'])->name('records.show');

    // Route for printing a specific record in an archive
    Route::get('/records/{arch}/{id}/print', [SearchController::class, 'print'])->name('records.print');

    // Routes for Denmark Emigration
    Route::get('/danishemigration/show/{id}', [DenmarkEmigrationController::class, 'show'])->name('danishemigration.show');
    Route::match(['get', 'post'], '/danishemigration/search', [DenmarkEmigrationController::class, 'search'])->name('danishemigration.search');


    //        // image related routes
    //        Route::get('npr/{index_letter}', [NorthenPacificRailwayCompanyRecordController::class,'browse'])->name('npr.browse');
    //
    ////        DalslanningarBornInAmericaRecord
    //
    //        Route::get('/dbir/show/{id}', [DalslanningarBornInAmericaRecordController::class, 'show'])
    //            ->name('dbir.show');
    //        Route::match(['get', 'post'],'/dbir/search', [DalslanningarBornInAmericaRecordController::class, 'search'])->name('dbir.search');
    //
    ////        SwedishAmericanChurchArchiveRecord
    //        Route::match(['get', 'post'],'/sacar/search', [SwedishAmericanChurchArchiveRecordController::class, 'search'])->name('sacar.search');
    //
    //        Route::match(['get', 'post'],'/nypr/search', [NewYorkPassengerRecordController::class, 'search'])->name('nypr.search');
    //
    //        Route::match(['get', 'post'],'/spplr/search', [SwedishPortPassengerListRecordController::class, 'search'])->name('spplr.search');
    //
    //
    //
    //        Route::match(['get', 'post'],'/scerc/search', [SwedishChurchEmigrationRecordController::class, 'search'])->name('scerc.search');
    //        Route::get('/scerc/statics', [SwedishChurchEmigrationRecordController::class, 'statics'])->name('scerc.statics');
    //        Route::post('/scerc/chart', [SwedishChurchEmigrationRecordController::class, 'generateChart'])->name('scerc.generateChart');
    //        Route::get('/scerc/photos', [SwedishChurchEmigrationRecordController::class, 'searchPhotos'])->name('scerc.photos');
    //        Route::match(['get', 'post'],'/scerc/photos-results', [SwedishChurchEmigrationRecordController::class, 'resultPhotos'])->name('scerc.result-photos');
    //
    //
    //        Route::get('/scirc/statics', [SwedishChurchImmigrantRecordController::class, 'statics'])->name('scirc.statics');
    //        Route::post('/scirc/chart', [SwedishChurchImmigrantRecordController::class, 'generateChart'])->name('scirc.generateChart');
    //        Route::match(['get', 'post'],'/scirc/search', [SwedishChurchImmigrantRecordController::class, 'search'])->name('scirc.search');
    //
    //        Route::match(['get', 'post'],'/sevkrc/search', [SwedishEmigrantViaKristianiaRecordController::class, 'search'])->name('sevkrc.search');
    //
    //        Route::match(['get', 'post'],'/sisrc/search', [SwedishImmigrationStatisticsRecordController::class, 'search'])->name('sisrc.search');
    //
    //
    //        Route::match(['get', 'post'],'/sesrc/search', [SwedishEmigrationStatisticsRecordController::class, 'search'])->name('sesrc.search');
    //
    //        Route::match(['get', 'post'],'/leprc/search', [LarssonEmigrantPopularRecordController::class, 'search'])->name('leprc.search');
    //
    //        Route::match(['get', 'post'],'/blarc/search', [BrodernaLarssonArchiveRecordController::class, 'search'])->name('blarc.search');
    //        Route::get('/blarc/browse', [BrodernaLarssonArchiveRecordController::class, 'browseYear'])->name('blarc.browse');
    //        Route::get('/blarc/browse/{year}', [BrodernaLarssonArchiveRecordController::class, 'browseDocuments'])->name('blarc.documents');
    //
    //
    //        Route::match(['get', 'post'],'/jear/search', [JohnEricssonsArchiveRecordController::class, 'search'])->name('jear.search');
    //
    //        Route::match(['get', 'post'],'/ncirc/search', [NorwegianChurchImmigrantRecordController::class, 'search'])->name('ncirc.search');
    //
    //        Route::match(['get', 'post'],'/msprc/search', [MormonShipPassengerRecordController::class, 'search'])->name('msprc.search');
    //
    //        Route::match(['get', 'post'],'/samrc/search', [SwedishAmericanMemberRecordController::class, 'search'])->name('samrc.search');
    //
    //        Route::match(['get', 'post'],'/siarc/search', [SwedeInAlaskaRecordController::class, 'search'])->name('siarc.search');
    //
    //        Route::match(['get', 'post'],'/vnnrc/search', [VarmlandskaNewspaperNoticeRecordController::class, 'search'])->name('vnnrc.search');
    //
    //        Route::match(['get', 'post'],'/nerc/search', [NorwayEmigrationRecordController::class, 'search'])->name('nerc.search');
    //
    //        Route::match(['get', 'post'],'/ierc/search', [IcelandEmigrationRecordController::class, 'search'])->name('ierc.search');
    //
    //        Route::match(['get', 'post'],'/sajr/search', [SwedishAmericanJubileeRecordController::class, 'search'])->name('sajr.search');
    //
    //        Route::match(['get', 'post'],'/rsphr/search', [RsPersonalHistoryRecordController::class, 'search'])->name('rsphr.search');
    //
    //        Route::match(['get', 'post'],'/suscepc/search', [SwedishUsaCentersEmiPhotoRecordController::class, 'search'])->name('suscepc.search');
    //
    //        Route::match(['get', 'post'],'/scpsr/search', [SwensonCenterPhotosamlingRecordController::class, 'search'])->name('scpsr.search');
    //
    //
    //        Route::match(['get', 'post'],'/sabr/search', [SwedishAmericanBookRecordController::class, 'search'])->name('sabr.search');


    // Route for sending suggestions via email
    Route::post('/suggestion', [SendEmailsController::class, 'sendSuggestion'])->name('suggestion');

    // Subscription routes
    Route::post('/subscribe', [SubscriptionController::class, 'store'])->name('subscribe.create'); // Route to create subscription
    Route::get('/subscribe/cancel', [SubscriptionController::class, 'destroy'])->name('subscribe.cancel'); // Route to cancel subscription
    Route::post('/subscribe/{id}/update', [SubscriptionController::class, 'update'])->name('subscribe.update'); // Route to update subscription
    });

// Routes with middleware for authentication, verification, user home check, roles, activity status, and manual subscription
Route::middleware(['auth', 'verified', 'userIsHome', 'role:super admin|emiweb admin|emiweb staff|organization admin|organization staff|subscriber|organizational subscriber', 'isActive', 'isManualSubscriber'])
    ->group(function () {

        // Route for searching ObituariesSweUsaNewspapersRecord
        Route::match(['get', 'post'], '/osanr/search', [ObituariesSweUsaNewspapersRecordController::class, 'search'])->name('osanr.search');

        // Route for browsing NorthenPacificRailwayCompanyRecord
        Route::get('npr/{index_letter}', [NorthenPacificRailwayCompanyRecordController::class, 'browse'])->name('npr.browse');

        // Routes for DalslanningarBornInAmericaRecord
        Route::get('/dbir/show/{id}', [DalslanningarBornInAmericaRecordController::class, 'show'])->name('dbir.show');
        Route::match(['get', 'post'], '/dbir/search', [DalslanningarBornInAmericaRecordController::class, 'search'])->name('dbir.search');

        // Routes for SwedishAmericanChurchArchiveRecord
        Route::match(['get', 'post'], '/sacar/search', [SwedishAmericanChurchArchiveRecordController::class, 'search'])->name('sacar.search');

        // Routes for NewYorkPassengerRecord
        Route::match(['get', 'post'], '/nypr/search', [NewYorkPassengerRecordController::class, 'search'])->name('nypr.search');

        // Routes for SwedishPortPassengerListRecord
        Route::match(['get', 'post'], '/spplr/search', [SwedishPortPassengerListRecordController::class, 'search'])->name('spplr.search');

        // Routes for SwedishChurchEmigrationRecordController
        Route::match(['get', 'post'], '/scerc/search', [SwedishChurchEmigrationRecordController::class, 'search'])->name('scerc.search');
        Route::get('/scerc/statics', [SwedishChurchEmigrationRecordController::class, 'statics'])->name('scerc.statics');
        Route::post('/scerc/chart', [SwedishChurchEmigrationRecordController::class, 'generateChart'])->name('scerc.generateChart');
        Route::get('/scerc/photos', [SwedishChurchEmigrationRecordController::class, 'searchPhotos'])->name('scerc.photos');
        Route::match(['get', 'post'], '/scerc/photos-results', [SwedishChurchEmigrationRecordController::class, 'resultPhotos'])->name('scerc.result-photos');

        // Routes for SwedishChurchImmigrantRecordController
        Route::get('/scirc/statics', [SwedishChurchImmigrantRecordController::class, 'statics'])->name('scirc.statics');
        Route::post('/scirc/chart', [SwedishChurchImmigrantRecordController::class, 'generateChart'])->name('scirc.generateChart');
        Route::match(['get', 'post'], '/scirc/search', [SwedishChurchImmigrantRecordController::class, 'search'])->name('scirc.search');

        // Routes for SwedishEmigrantViaKristianiaRecordController
        Route::match(['get', 'post'], '/sevkrc/search', [SwedishEmigrantViaKristianiaRecordController::class, 'search'])->name('sevkrc.search');

        // Routes for SwedishImmigrationStatisticsRecordController
        Route::match(['get', 'post'], '/sisrc/search', [SwedishImmigrationStatisticsRecordController::class, 'search'])->name('sisrc.search');

        // Routes for SwedishEmigrationStatisticsRecordController
        Route::match(['get', 'post'], '/sesrc/search', [SwedishEmigrationStatisticsRecordController::class, 'search'])->name('sesrc.search');

        // Routes for LarssonEmigrantPopularRecordController
        Route::match(['get', 'post'], '/leprc/search', [LarssonEmigrantPopularRecordController::class, 'search'])->name('leprc.search');

        // Routes for BrodernaLarssonArchiveRecordController
        Route::match(['get', 'post'], '/blarc/search', [BrodernaLarssonArchiveRecordController::class, 'search'])->name('blarc.search');
        Route::get('/blarc/browse', [BrodernaLarssonArchiveRecordController::class, 'browseYear'])->name('blarc.browse');
        Route::get('/blarc/browse/{year}', [BrodernaLarssonArchiveRecordController::class, 'browseDocuments'])->name('blarc.documents');

        // Routes for JohnEricssonsArchiveRecordController
        Route::match(['get', 'post'], '/jear/search', [JohnEricssonsArchiveRecordController::class, 'search'])->name('jear.search');

        // Routes for NorwegianChurchImmigrantRecordController
        Route::match(['get', 'post'], '/ncirc/search', [NorwegianChurchImmigrantRecordController::class, 'search'])->name('ncirc.search');

        // Routes for MormonShipPassengerRecordController
        Route::match(['get', 'post'], '/msprc/search', [MormonShipPassengerRecordController::class, 'search'])->name('msprc.search');

        // Routes for SwedishAmericanMemberRecordController
        Route::match(['get', 'post'], '/samrc/search', [SwedishAmericanMemberRecordController::class, 'search'])->name('samrc.search');

        // Routes for SwedeInAlaskaRecordController
        Route::match(['get', 'post'], '/siarc/search', [SwedeInAlaskaRecordController::class, 'search'])->name('siarc.search');

        // Routes for VarmlandskaNewspaperNoticeRecordController
        Route::match(['get', 'post'], '/vnnrc/search', [VarmlandskaNewspaperNoticeRecordController::class, 'search'])->name('vnnrc.search');

        // Routes for NorwayEmigrationRecordController
        Route::match(['get', 'post'], '/nerc/search', [NorwayEmigrationRecordController::class, 'search'])->name('nerc.search');

        // Routes for IcelandEmigrationRecordController
        Route::match(['get', 'post'], '/ierc/search', [IcelandEmigrationRecordController::class, 'search'])->name('ierc.search');

        // Routes for SwedishAmericanJubileeRecordController
        Route::match(['get', 'post'], '/sajr/search', [SwedishAmericanJubileeRecordController::class, 'search'])->name('sajr.search');

        // Routes for RsPersonalHistoryRecordController
        Route::match(['get', 'post'], '/rsphr/search', [RsPersonalHistoryRecordController::class, 'search'])->name('rsphr.search');

        // Routes for SwedishUsaCentersEmiPhotoRecordController
        Route::match(['get', 'post'], '/suscepc/search', [SwedishUsaCentersEmiPhotoRecordController::class, 'search'])->name('suscepc.search');

        // Routes for SwensonCenterPhotosamlingRecordController
        Route::match(['get', 'post'], '/scpsr/search', [SwensonCenterPhotosamlingRecordController::class, 'search'])->name('scpsr.search');

        // Routes for BevaringensLevnadsbeskrivningarRecordController
        Route::match(['get', 'post'], '/blbrc/search', [BevaringensLevnadsbeskrivningarRecordController::class, 'search'])->name('blbrc.search');

        // Routes for SwedishAmericanBookRecordController
        Route::match(['get', 'post'], '/sabr/search', [SwedishAmericanBookRecordController::class, 'search'])->name('sabr.search');

        //        Route::match(['get', 'post'],'/osanr/search', [ObituariesSweUsaNewspapersRecordController::class, 'search'])->name('osanr.search');
    });
