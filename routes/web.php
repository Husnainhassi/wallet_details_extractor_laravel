<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\WalletAnalyzerController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/wallet-list', [WalletAnalyzerController::class, 'walletList'])->name('wallet_list');