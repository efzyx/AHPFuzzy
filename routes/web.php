<?php

use App\Http\Controllers\ExpertController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\KriteriaKriteriaController;
use App\Http\Controllers\PemasokController;
use App\Http\Controllers\PemasokSubController;
use App\Http\Controllers\ResultController;
use App\Http\Controllers\SubKriteriaController;
use App\Http\Controllers\SubKriteriaSubKriteriaController;
use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [KriteriaController::class, 'index']);
    
    // Result routes
    Route::get('/result', [ResultController::class, 'index'])->name('result');
    Route::get('/gAhpKri', [ResultController::class, 'gAhpKri'])->name('gAhpKri');
    Route::get('/gAhpSub', [ResultController::class, 'gAhpSub'])->name('gAhpSub');
    Route::get('/gAhpPem', [ResultController::class, 'gAhpPem'])->name('gAhpPem');
    Route::get('/gFuzKri', [ResultController::class, 'gFuzKri'])->name('gFuzKri');
    Route::get('/gFuzSub', [ResultController::class, 'gFuzSub'])->name('gFuzSub');
    Route::get('/gFuzPem', [ResultController::class, 'gFuzPem'])->name('gFuzPem');

    // Resource routes
    Route::resource('kriterias', KriteriaController::class);
    Route::resource('subKriterias', SubKriteriaController::class);
    Route::resource('experts', ExpertController::class);
    Route::resource('kriteriaKriterias', KriteriaKriteriaController::class);
    Route::resource('subKriteriaSubKriterias', SubKriteriaSubKriteriaController::class);
    Route::resource('pemasoks', PemasokController::class);
    Route::resource('pemasokSubs', PemasokSubController::class);
    
    // Nested resource routes
    Route::resource('kriterias.SubKriterias', SubKriteriaController::class);
    Route::resource('experts.pemasokSubs', PemasokSubController::class);

    // Custom create routes
    Route::get('/kriteriaKriterias/create/{id}', [KriteriaKriteriaController::class, 'create'])->name('CreateKriteriaKriteria');
    Route::get('/subKriterias/create/{id}', [SubKriteriaController::class, 'create'])->name('CreateSubKriteria');
    Route::get('/subKriteriaSubKriterias/create/{id}', [SubKriteriaSubKriteriaController::class, 'create'])->name('CreateSubKriteriaSubKriteria');
    Route::get('/subKriterias/kriterias/{id}', [SubKriteriaSubKriteriaController::class, 'kriteria'])->name('showKriterias');

    // Delete routes
    Route::delete('/destroyAllByExpertId/{expert_id}', [KriteriaKriteriaController::class, 'destroyAllByExpertId'])->name('dKri');
    Route::delete('/destroyAllSubByKriteriaId/{kriteria_id}', [SubKriteriaSubKriteriaController::class, 'destroyAllByKriteriaId'])->name('dSub');
    Route::delete('/destroyAllPSubsByExpertId/{expert_id}', [PemasokSubController::class, 'destroyAllByExpertId'])->name('dPSub');
});

