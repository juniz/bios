<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/perawat', [App\Http\Controllers\SDM\PerawatController::class, 'index'])->named('perawat');
Route::post('/perawat/kirim', [App\Http\Controllers\SDM\PerawatController::class, 'store']);

Route::get('/bidan', [App\Http\Controllers\SDM\BidanController::class, 'index'])->named('bidan');
Route::post('/bidan/kirim', [App\Http\Controllers\SDM\BidanController::class, 'store']);

Route::get('/laboratorium', [App\Http\Controllers\SDM\LaboratoriumController::class, 'index'])->named('laboratorium');
Route::post('/laboratorium/kirim', [App\Http\Controllers\SDM\LaboratoriumController::class, 'store']);

Route::get('/nutritionist', [App\Http\Controllers\SDM\NutritionistController::class, 'index'])->named('nutritionist');
Route::post('/nutritionist/kirim', [App\Http\Controllers\SDM\NutritionistController::class, 'store']);

Route::get('/radiographer', [App\Http\Controllers\SDM\RadiographerController::class, 'index'])->named('radiographer');
Route::post('/radiographer/kirim', [App\Http\Controllers\SDM\RadiographerController::class, 'store']);

Route::get('/pharmacist', [App\Http\Controllers\SDM\PharmacistController::class, 'index'])->named('pharmacist');
Route::post('/pharmacist/kirim', [App\Http\Controllers\SDM\PharmacistController::class, 'store']);

Route::get('/profesionallainnya', [App\Http\Controllers\SDM\ProfessionalLainnyaController::class, 'index'])->named('profesionallainnya');
Route::post('/profesionallainnya/kirim', [App\Http\Controllers\SDM\ProfessionalLainnyaController::class, 'store']);

Route::get('/nonmedis', [App\Http\Controllers\SDM\NonMedisController::class, 'index'])->named('nonmedis');
Route::post('/nonmedis/kirim', [App\Http\Controllers\SDM\NonMedisController::class, 'store']);

Route::get('/sanitarian', [App\Http\Controllers\SDM\SanitarianController::class, 'index'])->named('sanitarian');
Route::post('/sanitarian/kirim', [App\Http\Controllers\SDM\SanitarianController::class, 'store']);

Route::get('/administrasi', [App\Http\Controllers\SDM\AdministrasiController::class, 'index'])->named('administrasi');
Route::post('/administrasi/kirim', [App\Http\Controllers\SDM\AdministrasiController::class, 'store']);

Route::get('/spesialis', [App\Http\Controllers\SDM\SpesialisController::class, 'index'])->named('spesialis');
Route::post('/spesialis/kirim', [App\Http\Controllers\SDM\SpesialisController::class, 'store']);

Route::get('/doktergigi', [App\Http\Controllers\SDM\DokterGigiController::class, 'index'])->named('doktergigi');
Route::post('/doktergigi/kirim', [App\Http\Controllers\SDM\DokterGigiController::class, 'store']);

Route::get('/dokterumum', [App\Http\Controllers\SDM\DokterUmumController::class, 'index'])->named('dokterumum');
Route::post('/dokterumum/kirim', [App\Http\Controllers\SDM\DokterUmumController::class, 'store']);