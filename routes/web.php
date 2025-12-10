<?php

use App\Http\Controllers\Admin\AdminBookingController;
use App\Http\Controllers\Admin\AdminCategoryController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminPaymentController;
use App\Http\Controllers\Admin\AdminRefundController;
use App\Http\Controllers\Admin\AdminReportController;
use App\Http\Controllers\Admin\AdminSettingController;
use App\Http\Controllers\Admin\AdminStaffController;
use App\Http\Controllers\Admin\AdminTicketTypeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminVenueController;
use App\Http\Controllers\Manager\ManagerBookingController;
use App\Http\Controllers\Manager\ManagerEventController;
use App\Http\Controllers\Manager\ManagerReportController;
use App\Http\Controllers\Manager\ManagerTicketTypeController;
use App\Http\Controllers\Manager\ManagerVenueController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Home', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/events', function () {
    return Inertia::render('Customer/Events');
})->name('events');

Route::get('/categories', function () {
    return Inertia::render('Customer/Category');
})->name('categories');

Route::get('/my-tickets', function () {
    return Inertia::render('Dashboard');
})->name('my-tickets');

Route::get('/my-bookings', function () {
    return Inertia::render('Dashboard');
})->name('my-bookings');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// for Admin
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:Admin'])->group(function () {

    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::resource('event-categories', AdminCategoryController::class);
    Route::resource('events', AdminEventController::class);
    Route::resource('venues', AdminVenueController::class);
    Route::resource('ticket-types', AdminTicketTypeController::class);
    Route::resource('bookings', AdminBookingController::class);
    Route::resource('payments', AdminPaymentController::class);
    Route::resource('refunds', AdminRefundController::class);
    Route::resource('users', AdminUserController::class);
    Route::resource('staff', AdminStaffController::class);
    Route::resource('reports', AdminReportController::class);
    Route::resource('settings', AdminSettingController::class);
});

// for Event Manager

Route::prefix('manager')->name('manager.')->middleware(['auth', 'role:Event Manager'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    Route::resource('events', ManagerEventController::class);
    Route::resource('venues', ManagerVenueController::class);
    Route::resource('ticket-types', ManagerTicketTypeController::class);
    Route::resource('bookings', ManagerBookingController::class);
    Route::resource('reports', ManagerReportController::class);
});

// for Organizer
Route::prefix('organizer')->name('organizer.')->middleware(['auth', 'role:Organizer'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');


    //   Route::resource('events', OrganizerEventController::class);
    // Route::resource('ticket-types', OrganizerTicketTypeController::class);
    // Route::resource('bookings', OrganizerBookingController::class);
    // Route::resource('reports', OrganizerReportController::class);
});

// for Customer Support
Route::prefix('support')->name('support.')->middleware(['auth', 'role:Customer Support'])->group(function () {
    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');

    // Route::resource('bookings', SupportBookingController::class)->only(['index', 'show']);
    // Route::resource('refunds', SupportRefundController::class)->only(['index', 'show', 'edit', 'update']);
    // Route::resource('customers', SupportCustomerController::class)->only(['index', 'show']);
});

// for Staff
Route::prefix('staff')->name('staff.')->middleware(['auth', 'role:Staff'])->group(function () {

    Route::get('/dashboard', fn() => Inertia::render('Dashboard'))->name('dashboard');


    // Route::get('scanner', [StaffScannerController::class, 'index'])->name('scanner');
    // Route::resource('bookings', StaffBookingController::class)->only(['index', 'show']);
});

// for Customer
Route::prefix('customer')->name('customer.')->middleware(['auth', 'role:Customer'])->group(function () {
    // Route::get('/home', fn() => Inertia::render('Home'))->name('home');

    // Route::resource('events', CustomerEventController::class)->only(['index', 'show']);
    // Route::resource('bookings', CustomerBookingController::class)->only(['index', 'show', 'create', 'store']);
});


require __DIR__ . '/auth.php';
