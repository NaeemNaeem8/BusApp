<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Mobile\BookingController as MobileBookingController;
use App\Http\Controllers\Mobile\TripController as MobileTripController;
use App\Http\Controllers\Mobile\UserController as  MobileUserController;
use App\Http\Controllers\Mobile\UserDayController as MobileUserDayController;
use App\Http\Controllers\Panel\BusController;
use App\Http\Controllers\Panel\DashboardController;
use App\Http\Controllers\Panel\DayController;
use App\Http\Controllers\Panel\DriverController;
use App\Http\Controllers\Panel\LineController as PanelLineController;
use App\Http\Controllers\Panel\LineParkingController;
use App\Http\Controllers\Panel\LineTripController;
use App\Http\Controllers\Panel\ParkingController;
use App\Http\Controllers\Panel\SupervisorController as PanelSupervisorController;
use App\Http\Controllers\Panel\TripController;
use App\Http\Controllers\Panel\UniversityController;
use App\Http\Controllers\Panel\UserPanelController;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Route;


Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
});

Route::get('universities', [UniversityController::class, 'index']);
################################ Mobile #################################



################################# restore user account #################################
Route::post('users/restore', [MobileUserController::class, 'restore_account']);


Route::middleware(['auth:sanctum'])->group(function () {

    #################################  User Route #################################
    Route::apiResource('users', MobileUserController::class)->only(['index', 'destroy'])
        ->parameter('id', 'user_id');

    Route::controller(MobileUserController::class)->prefix('users')->group(function () {
        Route::post('/update', 'update');
        Route::post('/change/register_type', 'change_register_type');
    });
    #################################  End User Route #################################
    Route::apiResource('user_days', MobileUserDayController::class)->except(['show'])
        ->parameter('user_days', 'user_day_id');

    Route::controller(MobileBookingController::class)->prefix('bookings')->group(function () {
        Route::post('/', 'store');
        Route::get('/user', 'index');
        Route::post('/approve/{book_id}', 'update');
    });

    Route::apiResource('supervisor/trips', MobileTripController::class)->only(['index']);
});


################################ End Mobile #################################







################################ Panel #################################

Route::middleware('auth:sanctum')->group(function () {

    #################################  day Route #################################
    Route::apiResource('days', DayController::class)->only(['index', 'destroy'])
        ->parameter('days', 'day_id');

    Route::controller(DayController::class)->prefix('days')->group(function () {
        Route::get('/deleted', 'deleted_day');
        Route::post('/restore/day/{day_id}', 'restore_day');
    });
    #################################  End day Route #################################

    #################################  Supervisor Route #################################
    Route::apiResource('supervisors', PanelSupervisorController::class)->except(['update', 'show'])
        ->parameter('supervisors', 'supervisor_id');

    Route::controller(PanelSupervisorController::class)->prefix('supervisors')->group(function () {
        Route::post('/update/{supervisor_id}', 'update');
        Route::get('/deleted/account', 'deleted_account');
        Route::post('/restore/account/{supervisor_id}', 'restore_account');
    });
    Route::get('select/supervisors', [PanelSupervisorController::class, 'select_supervisors']);
    #################################  End Supervisor Route #################################

    #################################  University Route #################################
    Route::apiResource('universities', UniversityController::class)->only(['show', 'store', 'destroy'])
        ->parameter('universities', 'university_id');

    Route::controller(UniversityController::class)->prefix('university')->group(function () {
        Route::get('/deactivated', 'deactivated_universities');
        Route::post('/update/{university_id}', 'update');
        Route::post('/restore/{university_id}', 'restore');
    });
    #################################  End University Route #################################

    #################################  Line Route #################################
    Route::apiResource('lines', PanelLineController::class)->only(['index', 'store'])
        ->parameter('lines', 'line_id');
    Route::post('lines/update/{line_id}', [PanelLineController::class, 'update']);
    Route::get('line_select', [PanelLineController::class, 'line_select']);
    #################################  End Line Route #################################


    #################################  Parking Route #################################
    Route::apiResource('parkings', ParkingController::class)->only(['index', 'store', 'update'])
        ->parameter('parkings', 'parking_id');
    Route::get('select/parkings', [ParkingController::class, 'select_parkings']);
    #################################  End Parking Route #################################

    #################################  Trip Route #################################
    Route::apiResource('trips', TripController::class)
        ->parameter('trips', 'trip_id');
    Route::controller(TripController::class)->prefix('trips')->group(function () {
        Route::post('/search', 'search');
        Route::post('/add/parkings', 'line_parkings');
    });
    #################################  End Trip Route #################################

    #################################  Bus Route #################################
    Route::apiResource('buses', BusController::class)->except(['destroy', 'show'])
        ->parameter('buses', 'bus_id');
    Route::get('select/buses', [BusController::class, 'select_buses']);
    #################################  End Bus Route #################################

    #################################  Driver Route #################################
    Route::apiResource('drivers', DriverController::class)->except(['destroy', 'show', 'update'])
        ->parameter('drivers', 'driver_id');
    Route::post('drivers/update/{driver_id}', [DriverController::class, 'update'])->name('driver_update');
    Route::get('select/drivers', [DriverController::class, 'select_drivers']);
    #################################  End Driver Route #################################


    #################################  LineTrip Route #################################
    Route::apiResource('line_trips', LineTripController::class)->only(['destroy', 'update', 'index'])
        ->parameter('line_trips', 'line_trip_id');
    #################################  End LineTrip Route #################################

    #################################  LineParking Route #################################
    Route::apiResource('line_parking', LineParkingController::class)
        ->parameter('line_parking', 'line_parking_id');
    #################################  End LineParking Route #################################
    Route::controller(DashboardController::class)->prefix('dashboard')->group(function () {
        Route::get('/', 'index');
        Route::get('/line_count', 'line_count');
    });

    Route::controller(UserPanelController::class)->prefix('users_panel')->group(function () {
        Route::get('/', 'index');
        Route::get('/count', 'deactivated_users_count');
        Route::get('/deactivated', 'deactivated_users');
        Route::post('/update/{user_id}', 'update');
        Route::delete('/delete/{user_id}', 'destroy');
        Route::get('/{user_id}', 'show');
    });

});


################################ End Panel #################################
