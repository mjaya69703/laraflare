<?php

use App\Http\Controllers\DomainController;
use App\Http\Controllers\RecordController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('domains.index');
});

Route::get('/domains', [DomainController::class, 'index'])->name('domains.index');
Route::get('/domains/{domain}/records', [DomainController::class, 'records'])->name('domains.records');

Route::post('/domains/{domain}/records', [RecordController::class, 'store'])->name('records.store');
Route::put('/domains/{domain}/records/{record}', [RecordController::class, 'update'])->name('records.update');
Route::delete('/domains/{domain}/records/{record}', [RecordController::class, 'destroy'])->name('records.destroy');