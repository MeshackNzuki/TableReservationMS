<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\LocationsController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\ReservationController;
use App\Http\Controllers\Admin\TableController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\LocationReservationsController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\MenuController as FrontendMenuController;
use App\Http\Controllers\Frontend\ReservationController as FrontendReservationController;
use App\Http\Controllers\Frontend\WelcomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/optimize', function () {
    // Call the optimize command
    Artisan::call('optimize');

    return 'Optimization complete';
});

Route::get('/link', function () {
    Artisan::call('storage:link');
    return 'link complete';
});

Route::get('/', [WelcomeController::class, 'index']);
Route::get('/categories', [FrontendCategoryController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [FrontendCategoryController::class, 'show'])->name('categories.show');
Route::get('/menus-dev', [FrontendMenuController::class, 'index'])->name('menus.index');
Route::get('/menu-items/{id?}', [FrontendMenuController::class, 'menu_items'])->name('menus.menu_items');
Route::get('/thankyou', [WelcomeController::class, 'thankyou'])->name('thankyou');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->name('admin.')->prefix('admin')->group(function () {
    Route::get('/', [TableController::class, 'dashboard'])->name('dashboardIndex');
    Route::get('/reservation/show/{id?}', [ReservationController::class, 'show']);
    Route::post('/reservation/filter', [TableController::class, 'filter'])->name('reservationshome.filter');
    Route::post('/reservation/location-book', [ReservationController::class, 'show'])->name('reservations.store.location');
    Route::post('/reservation/location-delete/{id?}', [LocationReservationsController::class, 'destroy'])->name('reservations.destroy.location');
    
    // Categories Routes
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('/categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    Route::get('/categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

    // Menus Routes
    Route::get('/menus', [MenuController::class, 'index'])->name('menus.index');
    Route::get('/menus/create', [MenuController::class, 'create'])->name('menus.create');
    Route::post('/menus', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
    Route::get('/menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit');
    Route::put('/menus/{menu}', [MenuController::class, 'update'])->name('menus.update');
    Route::delete('/menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy');

    // Tables Routes
    Route::get('/tables', [TableController::class, 'index'])->name('tables.index');
    Route::get('/tables/create', [TableController::class, 'create'])->name('tables.create');
    Route::post('/tables', [TableController::class, 'store'])->name('tables.store');
    Route::get('/tables/{table}', [TableController::class, 'show'])->name('tables.show');
    Route::get('/tables/{table}/edit', [TableController::class, 'edit'])->name('tables.edit');
    Route::put('/tables/{table}', [TableController::class, 'update'])->name('tables.update');
    Route::delete('/tables/{table}', [TableController::class, 'destroy'])->name('tables.destroy');

    // Reservations Routes
    Route::get('/reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations/{reservation}/edit', [ReservationController::class, 'edit'])->name('reservations.edit');
    Route::put('/reservations/{reservation}', [ReservationController::class, 'update'])->name('reservations.update');
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])->name('reservations.destroy');
    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/reservations/{id}', [ReservationController::class, 'cancel'])->name('reservations.cancel');

    // Locations Routes
    Route::get('/locations', [LocationsController::class, 'index'])->name('locations.index');
    Route::get('/locations/create', [LocationsController::class, 'create'])->name('locations.create');
    Route::post('/locations', [LocationsController::class, 'store'])->name('locations.store');
    Route::get('/locations/{location}', [LocationsController::class, 'show'])->name('locations.show');
    Route::get('/locations/{location}/edit', [LocationsController::class, 'edit'])->name('locations.edit');
    Route::put('/locations/{location}', [LocationsController::class, 'update'])->name('locations.update');
    Route::delete('/locations/{location}', [LocationsController::class, 'destroy'])->name('locations.destroy');

    // Location Reservations Routes
    Route::get('/locationreservations', [LocationReservationsController::class, 'index'])->name('locationreservations.index');
    Route::get('/locationreservations/create', [LocationReservationsController::class, 'create'])->name('locationreservations.create');
    Route::post('/locationreservations', [LocationReservationsController::class, 'store'])->name('locationreservations.store');
    Route::get('/locationreservations/{locationreservation}', [LocationReservationsController::class, 'show'])->name('locationreservations.show');
    Route::get('/locationreservations/{locationreservation}/edit', [LocationReservationsController::class, 'edit'])->name('locationreservations.edit');
    Route::put('/locationreservations/{locationreservation}', [LocationReservationsController::class, 'update'])->name('locationreservations.update');
    Route::delete('/locationreservations/{locationreservation}', [LocationReservationsController::class, 'destroy'])->name('locationreservations.destroy');
    Route::post('/locationreservations/{id}', [LocationReservationsController::class, 'cancel'])->name('locationreservations.cancel');

    // Additional Routes
    Route::get('/reservation/history', [ReservationController::class, 'history'])->name('reservations.history');
    Route::get('/locationreservation/history', [LocationReservationsController::class, 'history'])->name('locationreservations.history');

    // Search Routes
    Route::post('/reservation/search', [ReservationController::class, 'search'])->name('reservations.search');
    Route::post('/reservation/search-history', [ReservationController::class, 'searchHistory'])->name('reservations.history.search');
    Route::post('/locationreservation/search', [LocationReservationsController::class, 'search'])->name('locationreservations.search');
    Route::post('/locationreservation/search-history', [LocationReservationsController::class, 'searchHistory'])->name('locationreservations.history.search');


    //reccurring

    Route::get('/recurring', [ReservationController::class, 'recurring_index'])->name('recurring.index');


    //user management
    Route::resource('users', UsersController::class);
    // Route::get('/user/index', [UserController::class, 'index'])->name('user.index');
    // Route::post('/user/create', [UserController::class, 'create'])->name('user.create');
    // Route::get('/user/edit', [UserController::class, 'edit'])->name('user.edit');
    // Route::post('/user/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
    // Route::post('/user/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
});

require __DIR__ . '/auth.php';
