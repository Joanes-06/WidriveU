<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Admin;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\ZoneController as AdminZoneController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/a-propos', [PageController::class, 'about'])->name('about');
Route::get('/notre-flotte', [VehicleController::class, 'index'])->name('fleet');
Route::get('/notre-flotte/{vehicle}', [VehicleController::class, 'show'])->name('vehicle.show');
Route::get('/contact', [PageController::class, 'contact'])->name('contact');
Route::post('/contact', [PageController::class, 'sendContact'])->name('contact.send');

// Auth routes
Route::middleware('guest')->group(function () {
    Route::get('/connexion', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/connexion', [AuthController::class, 'login']);
    Route::get('/inscription', [AuthController::class, 'registerForm'])->name('register');
    Route::post('/inscription', [AuthController::class, 'register']);
});
Route::post('/deconnexion', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Customer routes
Route::middleware('auth')->group(function () {
    Route::get('/tableau-de-bord', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/reservation/{vehicle}', [ReservationController::class, 'create'])->name('reservation.create');
    Route::post('/reservation', [ReservationController::class, 'store'])->name('reservation.store');
    Route::get('/paiement/succes', [ReservationController::class, 'paymentSuccess'])->name('payment.success');
    Route::get('/paiement/echec', [ReservationController::class, 'paymentFailure'])->name('payment.failure');
    Route::get('/paiement/{reservation}', [ReservationController::class, 'payment'])->name('payment.checkout');
    Route::post('/paiement/{reservation}/verifier', [ReservationController::class, 'verifyPayment'])->name('payment.verify');
    Route::get('/mes-reservations', [ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/mes-reservations/{reservation}', [ReservationController::class, 'show'])->name('reservations.show');
    Route::post('/mes-reservations/{reservation}/annuler', [ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::post('/mes-reservations/{reservation}/prolonger', [ReservationController::class, 'extend'])->name('reservations.extend');
    Route::get('/mes-reservations/{reservation}/contrat', [ReservationController::class, 'downloadContract'])->name('reservations.contract');
    Route::get('/mes-reservations/{reservation}/recu', [ReservationController::class, 'downloadReceipt'])->name('reservations.receipt');
    Route::get('/mes-reservations/{reservation}/prolonger', [ReservationController::class, 'showExtend'])->name('reservations.extend.show');
    // Extension payment (static routes before {extension} wildcard)
    Route::get('/paiement-extension/succes', [ReservationController::class, 'extensionSuccess'])->name('extension.success');
    Route::get('/paiement-extension/echec', [ReservationController::class, 'extensionFailure'])->name('extension.failure');
    Route::get('/paiement-extension/{extension}', [ReservationController::class, 'extensionPayment'])->name('extension.payment');
    Route::post('/paiement-extension/{extension}/verifier', [ReservationController::class, 'verifyExtensionPayment'])->name('extension.verify');
    Route::get('/mon-profil', [\App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/mon-profil/informations', [\App\Http\Controllers\ProfileController::class, 'updateInfo'])->name('profile.update.info');
    Route::post('/mon-profil/mot-de-passe', [\App\Http\Controllers\ProfileController::class, 'updatePassword'])->name('profile.update.password');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [Admin\DashboardController::class, 'index'])->name('dashboard');
    // Vehicles
    Route::get('/vehicules', [Admin\VehicleController::class, 'index'])->name('vehicles.index');
    Route::get('/vehicules/creer', [Admin\VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicules', [Admin\VehicleController::class, 'store'])->name('vehicles.store');
    Route::get('/vehicules/{vehicle}/modifier', [Admin\VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicules/{vehicle}', [Admin\VehicleController::class, 'update'])->name('vehicles.update');
    Route::delete('/vehicules/{vehicle}', [Admin\VehicleController::class, 'destroy'])->name('vehicles.destroy');
    // Reservations
    Route::get('/reservations/creer', [Admin\ReservationController::class, 'create'])->name('reservations.create');
    Route::post('/reservations', [Admin\ReservationController::class, 'store'])->name('reservations.store');
    Route::get('/reservations', [Admin\ReservationController::class, 'index'])->name('reservations.index');
    Route::get('/reservations/en-cours', [Admin\ReservationController::class, 'active'])->name('reservations.active');
    Route::get('/reservations/expirees', [Admin\ReservationController::class, 'expired'])->name('reservations.expired');
    Route::get('/reservations/{reservation}', [Admin\ReservationController::class, 'show'])->name('reservations.show');
    Route::put('/reservations/{reservation}/terminer', [Admin\ReservationController::class, 'complete'])->name('reservations.complete');
    Route::put('/reservations/{reservation}/annuler', [Admin\ReservationController::class, 'cancel'])->name('reservations.cancel');
    Route::put('/reservations/{reservation}/disponible', [Admin\ReservationController::class, 'makeAvailable'])->name('reservations.available');
    // Users / Clients
    Route::get('/clients', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/clients/{user}', [AdminUserController::class, 'show'])->name('users.show');
    // Zones
    Route::get('/zones', [AdminZoneController::class, 'index'])->name('zones.index');
    Route::post('/zones', [AdminZoneController::class, 'store'])->name('zones.store');
    Route::put('/zones/{zone}', [AdminZoneController::class, 'update'])->name('zones.update');
    Route::delete('/zones/{zone}', [AdminZoneController::class, 'destroy'])->name('zones.destroy');
    // Stats & Settings
    Route::get('/statistiques', [Admin\StatisticsController::class, 'index'])->name('statistics');
    Route::get('/parametres', [Admin\SettingsController::class, 'index'])->name('settings.index');
    Route::post('/parametres', [Admin\SettingsController::class, 'update'])->name('settings.update');
});
