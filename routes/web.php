<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PackageController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
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
        Route::get('/{eventId}/show', [EventController::class, 'showEvent'])->name('events.show');
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

    Route::prefix('contracts')->group(function () {
        Route::get('/generate-contract-for-event/{eventId}', [ContractController::class, 'generateContractForEvent'])->name('contracts.generate-contract-for-event');
        Route::get('/preview/{eventId}', [ContractController::class, 'generateContractPdfInBrowser'])->name('contracts.preview');
        Route::get('/download/{eventId}', [ContractController::class, 'generateContractPdfToDownload'])->name('contracts.download');
    });

    Route::prefix('emails')->group(function () {
        Route::get('/send-contract-email/{eventId}', [EmailController::class, 'sendContractEmail'])->name('send.contract.email');
        Route::get('/preview-contract-email/{eventId}', [EmailController::class, 'previewContractEmail'])->name('preview.contract.email');
    });

    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('view.login');

Route::post('/login', [AuthController::class, 'login'])->name('login');











