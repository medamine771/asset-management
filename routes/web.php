<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EmplacementController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\MailController;
// Route d'accueil
// Route::get('/', function () {
//     return view('dashboard');
// });



Route::resource('equipements', EquipementController::class);
Route::resource('categories', CategorieController::class);
Route::resource('emplacements', EmplacementController::class);
Route::resource('interventions', InterventionController::class);

// Route::middleware(['auth', 'admin'])->group(function () {
//    // Routes pour les ressources

// });

// Route::middleware(['auth', 'technicien'])->group(function () {
//     Route::get('/equipements-en-panne', [EquipementController::class, 'equipementsEnPanne'])->name('equipements.panne');
// });

// Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/', function () {
    return view('welcome');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

// Route::middleware(['auth', 'admin'])->group(function () {
//     Route::get('/admin/dashboard', function () {
//         return view('admin.dashboard');
//     })->name('admin.dashboard');
// });
use App\Http\Controllers\AdminDashboardController;

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');
});



Route::middleware(['auth', 'technicien'])->group(function () {
    Route::get('/technicien/dashboard', [DashboardController::class, 'index'])
        ->name('tech.dashboard');
});


// Formulaire d'inscription
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');

// Enregistrement
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::get('/equipements/panne', [EquipementController::class, 'equipementsEnPanne'])->name('equipements.panne')->middleware('auth');



