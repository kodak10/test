<?php

use Spatie\Permission\Models\Role;
use App\Http\Controllers\accesUtilisateurController;
use App\Http\Controllers\AuthentificationController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\secteurController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\departementController;
use App\Http\Controllers\demandesInscriptionController;
use App\Http\Controllers\WebsiteController;

// Route site Web
Route::get('/', [WebsiteController::class, 'index']);
Route::post('/services/search', [WebsiteController::class, 'search'])->name('services.search');

Route::get('/about', [WebsiteController::class, 'about']);
Route::get('/blog', [WebsiteController::class, 'blog']);
Route::get('/contact', [WebsiteController::class, 'contact']);
Route::get('/services', [WebsiteController::class, 'services']);
//Route::get('/services/{details}', [WebsiteController::class, 'services_detail']);
Route::get('/services/{slug}', [WebsiteController::class, 'serviceShow'])->name('serviceDetail.show');

Route::get('/login', [WebsiteController::class, 'login'])->name('login');
Route::get('/register', [WebsiteController::class, 'register']);




// Route Auth
Route::post('/login', [AuthentificationController::class, 'login'])->name('postLogin');
//Route::get('/login', [AuthentificationController::class, 'loginForm'])->name('login');
Route::post('/register/client', [AuthentificationController::class, 'registerClient'])->name('inscriptionClient');
Route::post('/register/entreprise', [AuthentificationController::class, 'registerEntreprise'])->name('inscriptionEntreprise');
Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout' ])->name('logout');


// Vos routes d'administration ici
Route::prefix('administration')->middleware(['auth', 'verified' ,'role:serviceClient'])->group(function () {

    Route::get('/', [App\Http\Controllers\demandesInscriptionController::class, 'index']);
    Route::get('/detail', function () {
        return view('Administration.detail');
    });
    // route des departements
    Route::resource('departements', departementController::class);
    // route des secteurs
    Route::resource('secteurs', secteurController::class);
    // route des services
    Route::resource('services', serviceController::class);
    // route des demandes d inscription
    Route::resource('demandes_inscription', demandesInscriptionController::class);
    // route des acces users
    Route::resource('acces_utilisateurs', accesUtilisateurController::class);
});

// Vos routes d'user ici
Route::prefix('user')->middleware(['auth', 'verified','role:client'])->group(function () {
    Route::get('/', function () {
        return view('Client.home');
    });

    Route::get('/detail', function () {
        return view('Client.detail');
    });
});

// Vos routes d'user ici
Route::prefix('compagny')->middleware(['auth', 'verified' ,'role:compagny'])->group(function () {
    Route::get('/', function () {
        return view('Entreprise.home');
    });
    Route::get('/detail', function () {
        return view('Entreprise.detail');
    });

});
