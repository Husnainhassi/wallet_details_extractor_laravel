<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [DefaultController::class, 'list'])->name('list');
Route::get('/excel-import-form', [DefaultController::class, 'excelImportForm'])->name('excel.import.form');
Route::get('/good-wallet', [DefaultController::class, 'goodWallet'])->name('good.wallet');


Route::post('/excel-import', [DefaultController::class, 'excelImport'])->name('wallet.import');
Route::post('/add-good-wallet', [DefaultController::class, 'addGoodWallet'])->name('add.good.wallet');