<?php

use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('packages')->group(function () {
    Route::get('/', [PackageController::class, 'paginate'])->name('packages.index');
    Route::get('/{packageId}/edit', [PackageController::class, 'getPackage'])->name('packages.edit');
    Route::get('/create', [PackageController::class, 'createPackage'])->name('packages.create');
    Route::post('/', [PackageController::class, 'storePackage'])->name('packages.store');
    Route::put('/{packageId}', [PackageController::class, 'updatePackage'])->name('packages.update');
    Route::delete('/{packageId}', [PackageController::class, 'deletePackage'])->name('packages.delete');
});



