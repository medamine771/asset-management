<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EquipementController;
use App\Http\Controllers\CategorieController;
use App\Http\Controllers\EmplacementController;
use App\Http\Controllers\InterventionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TechnicienController;
use App\Http\Controllers\StatistiquesController;

// Routes publiques
Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Routes protégées par authentification
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Routes pour les équipements
    Route::resource('equipements', EquipementController::class);
    Route::get('/equipements/panne', [EquipementController::class, 'equipementsEnPanne'])->name('equipements.panne');
    Route::patch('/equipements/{equipement}/updateEtat', [EquipementController::class, 'updateEtat'])
        ->name('equipements.updateEtat');
    Route::get('/equipements/{equipement}/interventions', [EquipementController::class, 'historique'])
        ->name('equipements.interventions');
    
    // Autres ressources
    Route::resource('categories', CategorieController::class);
    Route::resource('emplacements', EmplacementController::class);
    Route::resource('interventions', InterventionController::class);
    
    // Mise à jour statut intervention
    Route::patch('/interventions/{intervention}/status', [InterventionController::class, 'updateStatus'])
        ->name('interventions.updateStatus');
});

// Routes admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('techniciens', TechnicienController::class);
    Route::get('/statistiques', [StatistiquesController::class, 'index'])->name('statistiques.index');
});

// Routes technicien
Route::middleware(['auth', 'technicien'])->group(function () {
    Route::get('/technicien/dashboard', [DashboardController::class, 'index'])->name('tech.dashboard');
});

use App\Http\Controllers\ActifNumeriqueController;

Route::resource('actifs-numeriques', ActifNumeriqueController::class);

use App\Http\Controllers\MessageController;

Route::middleware(['auth'])->group(function () {
    Route::get('/messages/inbox', [MessageController::class, 'inbox'])->name('messages.inbox');
    Route::get('/messages/sent', [MessageController::class, 'sent'])->name('messages.sent');
    Route::get('/messages/create', [MessageController::class, 'create'])->name('messages.create');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    // Répondre à un message (formulaire)
    Route::get('messages/{message}/reply', [MessageController::class, 'reply'])->name('messages.reply');

// Envoyer la réponse
    Route::post('messages/{message}/reply', [MessageController::class, 'sendReply'])->name('messages.sendReply');
});

Route::get('/technician/messages', [MessageController::class, 'technicianInbox'])
     ->middleware('auth')
     ->name('technician.messages.inbox');
