<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\EventController;
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

Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'paginate'])->name('events.index');
    Route::get('/{eventId}/edit', [EventController::class, 'getEvent'])->name('events.edit');
    Route::get('/create', [EventController::class, 'createEvent'])->name('events.create');
    Route::post('/', [EventController::class, 'storeEvent'])->name('events.store');
    Route::put('/{eventId}', [EventController::class, 'updateEvent'])->name('events.update');
    Route::delete('/{eventId}', [EventController::class, 'deleteEvent'])->name('events.delete');
});

Route::prefix('clients')->group(function () {
    Route::get('/search-clients-by-keywords', [ClientController::class, 'searchClientsByKeywords'])->name('clients.search-clients-by-keywords');
});

Route::prefix('addresses')->group(function () {
    Route::get('/search-addresses-by-keywords', [AddressController::class, 'searchAddressesByKeywords'])->name('addresses.search-addresses-by-keywords');
});

