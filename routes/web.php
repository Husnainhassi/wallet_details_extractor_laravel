<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [DefaultController::class, 'list'])->name('list');
Route::get('/excel-import', [DefaultController::class, 'showImportForm'])->name('wallet.import.form');
Route::post('/excel-import', [DefaultController::class, 'excelImport'])->name('wallet.import');
