<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ListingOfferController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\NotificationSeenController;
use App\Http\Controllers\RealtorListingAcceptOfferController;
use App\Http\Controllers\RealtorListingController;
use App\Http\Controllers\RealtorListingImageController;
use App\Http\Controllers\UserAccountController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;

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

Route::get('/', [IndexController::class, 'index']);
Route::get('/hi', [IndexController::class, 'show'])
    ->middleware('auth');

Route::resource('listing', ListingController::class)
    ->only('index', 'show');
Route::resource('listing.offer', ListingOfferController::class)
     ->middleware('auth')
     ->only(['store']);
Route::resource('user', UserAccountController::class)
    ->only('create', 'store');
Route::resource('notification', NotificationController::class)
    ->middleware('auth')
    ->only('index');
Route::put('notification/{notification}/seen', NotificationSeenController::class)
    ->middleware('auth')
    ->name('notification.seen');
/*
  // alternative method in the app/Http/Controllers/ListingController.php class constructor
Route::resource('listing', ListingController::class)
    ->except('index', 'show')->middleware('auth');
Route::resource('listing', ListingController::class)
     ->only('index', 'show');
*/

Route::get('login', [AuthController::class, 'create'])
    ->name('login');
Route::post('login', [AuthController::class, 'store'])
     ->name('login.store');
Route::delete('logout', [AuthController::class, 'destroy'])
     ->name('logout');

Route::get('/email/verify', function () {
    return inertia('Auth/VerifyEmail');
})->middleware('auth')->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect()->route('listing.index')
                     ->with('success', 'Email was verified!');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('success', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.send');

Route::prefix('realtor')
    ->name('realtor.')
    ->middleware('auth', 'verified')
    ->group(function () {
        Route::name('listing.')
            ->prefix('listing/{listing}')
            ->group(function () {
                Route::put('restore', [RealtorListingController::class, 'restore'])
                     ->name('restore')->withTrashed();
                Route::delete('force-delete', [RealtorListingController::class, 'forceDelete'])
                     ->name('force-delete')->withTrashed();
            });
       Route::resource('listing', RealtorListingController::class)
            ->withTrashed();

        Route::name('offer.accept')
             ->put('offer/{offer}/accept', RealtorListingAcceptOfferController::class);

       Route::resource('listing.image', RealtorListingImageController::class)
            ->only(['create', 'store', 'destroy']);
    });