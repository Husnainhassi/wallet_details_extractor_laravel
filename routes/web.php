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

// Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions');
Route::get('/transactions', [TransactionController::class, 'getTokenTransactions']);
// routes/web.php
Route::get('/birdeye-data', function () {
    return view('birdeye-data');
});
Route::post('/proxy-birdeye', function () {
    $response = Http::withHeaders([
        'Content-Type' => 'application/json',
        'agent-id' => 'f3fe63d6-de8e-4925-b321-9b920e82e3b9',
        'page' => 'find-trades',
        'origin' => 'https://birdeye.so', // mimic the browser
        'referer' => 'https://birdeye.so/', // mimic referer
        'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/135.0.0.0 Safari/537.36'
    ])->post('https://multichain-api.birdeye.so/solana/amm/v2/txs/token', request()->all());

    return response()->json($response->json(), $response->status());
});

