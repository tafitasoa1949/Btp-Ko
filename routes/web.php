<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DevisMaisonController;
use App\Http\Controllers\MaisonController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [AuthController::class,'loadClient'])->name('loadClient');
Route::get('/admin', [AuthController::class,'index'])->name('login');
Route::post('/logout', [AuthController::class,'deconnexion'])->name('logout');
Route::post('/login', [AuthController::class,'se_login'])->name('se_login');
Route::post('/se_login_client', [AuthController::class,'se_login_client'])->name('se_login_client');
Route::get('/registre', [AuthController::class,'registre'])->name('registre');
Route::post('/inscription', [AuthController::class,'inscription'])->name('inscription');

Route::middleware(['auth', 'check.admin.role'])->group(function () {
    Route::get('/postes', [AuthController::class,'postes'])->name('postes');
    Route::resource('postes', App\Http\Controllers\PosteController::class);
    Route::resource('employes', App\Http\Controllers\EmployeController::class);
    Route::resource('comptes', App\Http\Controllers\CompteController::class);
    Route::resource('travails', App\Http\Controllers\TravailController::class);
    Route::resource('clients', App\Http\Controllers\ClientController::class);
    Route::resource('maisons', App\Http\Controllers\MaisonController::class);
    Route::resource('detail-maisons', App\Http\Controllers\DetailMaisonController::class);
    Route::resource('unites', App\Http\Controllers\UniteController::class);
    Route::resource('detail-travails', App\Http\Controllers\DetailTravailController::class);
    Route::resource('devis-maisons', App\Http\Controllers\DevisMaisonController::class);
    Route::resource('compte-devis-maisons', App\Http\Controllers\CompteDevisMaisonController::class);
    Route::resource('detail-devis', App\Http\Controllers\DetailDevisController::class);
    Route::resource('ss-details', App\Http\Controllers\SsDetailController::class);
    Route::get('deviss.export/{id}', [DevisMaisonController::class,'exports'])->name('deviss.export');
    Route::get('creer/{id}', [DevisMaisonController::class,'creer'])->name('creer');
    Route::post('creation', [DevisMaisonController::class,'creation'])->name('creation');
    Route::resource('finitions', App\Http\Controllers\FinitionController::class);
    Route::resource('achats', App\Http\Controllers\AchatController::class);
    Route::resource('tarif-achats', App\Http\Controllers\TarifAchatController::class);
    Route::resource('paiements', App\Http\Controllers\PaiementController::class);
    Route::get('devis', [DevisMaisonController::class,'devis'])->name('devis');
    Route::get('detail/{id}', [DevisMaisonController::class,'detail'])->name('detail');
    Route::get('stat_devis', [DevisMaisonController::class,'stat_devis'])->name('stat_devis');
    Route::post('stat_devisDate', [DevisMaisonController::class,'stat_devisDate'])->name('stat_devisDate');
    Route::get('stat.paiment', [App\Http\Controllers\PaiementController::class,'statistique'])->name('stat.paiment');
    Route::post('import.create', [App\Http\Controllers\MaisonController::class,'import'])->name('import.create');
    Route::post('import.paiement', [App\Http\Controllers\PaiementController::class,'import'])->name('import.paiement');
});

Route::middleware(['check.client'])->group(function () {
    Route::get('/home', [AuthController::class,'home'])->name('home');
    Route::get('devis.image', [DevisMaisonController::class,'image'])->name('devis.image');
    Route::get('devis.export/{id}', [DevisMaisonController::class,'export'])->name('devis.export');
    Route::get('devis.liste', [DevisMaisonController::class,'liste'])->name('devis.liste');
    Route::get('creer/{id}', [DevisMaisonController::class,'creer'])->name('creer');
    Route::get('devis.details/{id}', [DevisMaisonController::class,'details'])->name('devis.details');
    Route::post('creation', [DevisMaisonController::class,'creation'])->name('creation');
    Route::resource('achats', App\Http\Controllers\AchatController::class);
    Route::get('travaux', [DevisMaisonController::class,'travaux'])->name('travaux');
    Route::get('paiement', [App\Http\Controllers\PaiementController::class,'paiement'])->name('paiement');
    Route::get('faire.paiment/{id}', [App\Http\Controllers\PaiementController::class,'faire'])->name('faire.paiment');
    Route::post('payer_achat', [App\Http\Controllers\PaiementController::class,'payer_achat'])->name('payer_achat');
});

Route::get('/reinitialiser', [AuthController::class,'reinitialiser'])->name('reinitialiser');

