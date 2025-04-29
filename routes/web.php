<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletAnalyzerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/analyze', [WalletAnalyzerController::class, 'index'])->name('analyze');
Route::post('/analyze', [WalletAnalyzerController::class, 'analyze']);