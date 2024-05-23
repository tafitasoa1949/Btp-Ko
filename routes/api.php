<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::resource('postes', App\Http\Controllers\API\PosteAPIController::class)
    ->except(['create', 'edit']);

Route::resource('employes', App\Http\Controllers\API\EmployeAPIController::class)
    ->except(['create', 'edit']);

Route::resource('comptes', App\Http\Controllers\API\CompteAPIController::class)
    ->except(['create', 'edit']);

Route::resource('travails', App\Http\Controllers\API\TravailAPIController::class)
    ->except(['create', 'edit']);

Route::resource('clients', App\Http\Controllers\API\ClientAPIController::class)
    ->except(['create', 'edit']);

Route::resource('maisons', App\Http\Controllers\API\MaisonAPIController::class)
    ->except(['create', 'edit']);

Route::resource('detail-maisons', App\Http\Controllers\API\DetailMaisonAPIController::class)
    ->except(['create', 'edit']);

Route::resource('unites', App\Http\Controllers\API\UniteAPIController::class)
    ->except(['create', 'edit']);

Route::resource('detail-travails', App\Http\Controllers\API\DetailTravailAPIController::class)
    ->except(['create', 'edit']);

Route::resource('devis-maisons', App\Http\Controllers\API\DevisMaisonAPIController::class)
    ->except(['create', 'edit']);

Route::resource('compte-devis-maisons', App\Http\Controllers\API\CompteDevisMaisonAPIController::class)
    ->except(['create', 'edit']);

Route::resource('detail-devis', App\Http\Controllers\API\DetailDevisAPIController::class)
    ->except(['create', 'edit']);

Route::resource('ss-details', App\Http\Controllers\API\SsDetailAPIController::class)
    ->except(['create', 'edit']);

Route::resource('finitions', App\Http\Controllers\API\FinitionAPIController::class)
    ->except(['create', 'edit']);

Route::resource('achats', App\Http\Controllers\API\AchatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('tarif-achats', App\Http\Controllers\API\TarifAchatAPIController::class)
    ->except(['create', 'edit']);

Route::resource('paiements', App\Http\Controllers\API\PaiementAPIController::class)
    ->except(['create', 'edit']);