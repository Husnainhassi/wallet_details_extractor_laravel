<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\DefaultController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/list', [DefaultController::class, 'list'])->name('list');
Route::get('/excel-import', [DefaultController::class, 'excelImport'])->name('excel_import');