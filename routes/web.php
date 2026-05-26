<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SpaceController;
use App\Http\Controllers\HostSpaceController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReviewController;

/*
|--------------------------------------------------------------------------
| HOME
|--------------------------------------------------------------------------
*/

Route::get('/', [SpaceController::class, 'welcome'])->name('home');


/*
|--------------------------------------------------------------------------
| PUBLIC SPACES
|--------------------------------------------------------------------------
*/

Route::get('/spaces', [SpaceController::class, 'index'])->name('spaces.index');
Route::get('/spaces/{space}', [SpaceController::class, 'show'])->name('spaces.show');


/*
|--------------------------------------------------------------------------
| REVIEWS (PUBLIC VIEW, AUTH REQUIRED TO ADD)
|--------------------------------------------------------------------------
*/

Route::post('/spaces/{space}/review', [ReviewController::class, 'store'])
    ->middleware('auth')
    ->name('reviews.store');


/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');


/*
|--------------------------------------------------------------------------
| AUTH REQUIRED
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    /*
    | PROFILE
    */
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    /*
    | BECOME HOST
    */
    Route::post('/become-host', function () {

        $user = auth()->user();
        $user->role = 'host';
        $user->save();

        return redirect()->route('host.spaces.index')
            ->with('success', 'You are now a host!');

    })->name('become.host');

    /*
    | BOOKINGS
    */
    Route::get('/bookings/{space}', [BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings/{space}', [BookingController::class, 'store'])->name('bookings.store');

    Route::get('/booking-success', [BookingController::class, 'success'])->name('bookings.success');
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('bookings.my');

    /*
    | CANCEL BOOKING
    */
    Route::post('/booking/{booking}/cancel', [BookingController::class, 'cancel'])
        ->name('bookings.cancel');

    /*
    | PAYMENT
    */
    Route::get('/payment/{booking}', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment-success/{booking}', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment-cancel', [PaymentController::class, 'cancel'])->name('payment.cancel');

});


/*
|--------------------------------------------------------------------------
| HOST PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('host')
    ->name('host.')
    ->middleware(['auth','role:host,admin'])
    ->group(function () {

        Route::get('/spaces', [HostSpaceController::class, 'index'])->name('spaces.index');
        Route::get('/spaces/create', [HostSpaceController::class, 'create'])->name('spaces.create');
        Route::post('/spaces', [HostSpaceController::class, 'store'])->name('spaces.store');
        Route::get('/spaces/{space}/edit', [HostSpaceController::class, 'edit'])->name('spaces.edit');
        Route::put('/spaces/{space}', [HostSpaceController::class, 'update'])->name('spaces.update');
        Route::delete('/spaces/{space}', [HostSpaceController::class, 'destroy'])->name('spaces.destroy');

        Route::delete('/spaces/image/{image}', [HostSpaceController::class, 'deleteImage'])
            ->name('spaces.image.delete');

});


/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/
/*
|--------------------------------------------------------------------------
| ADMIN PANEL
|--------------------------------------------------------------------------
*/

Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth','role:admin'])
    ->group(function () {

        Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

        Route::get('/spaces', [AdminController::class, 'spaces'])->name('spaces');

        Route::get('/bookings', [AdminController::class, 'bookings'])->name('bookings');

        // ✅ FIXED DELETE ROUTES (NO /admin again)
        Route::delete('/spaces/{space}', [AdminController::class, 'deleteSpace'])
            ->name('spaces.delete');

        Route::delete('/bookings/{booking}', [AdminController::class, 'deleteBooking'])
            ->name('bookings.delete');

});
/*
|--------------------------------------------------------------------------
| AUTH ROUTES (BREEZE)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';