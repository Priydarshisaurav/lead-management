<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QuotationController;
use App\Http\Controllers\SalesController;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('profile', [ProfileController::class, 'show'])->name('profile.show');
});

require __DIR__ . '/auth.php';


Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::resource('leads', LeadController::class);

    // Route::post('leads/{lead}/move-stage',
    //     [LeadController::class,'moveStage'])
    //     ->name('leads.moveStage');

    Route::resource('quotations', QuotationController::class);
});

Route::get('leads/create', [LeadController::class, 'create'])->name('leads.create');

Route::post('/leads/{lead}/move-stage', [LeadController::class, 'moveStage'])
    ->name('leads.moveStage')
    ->middleware('auth');

Route::post('/quotations', [QuotationController::class, 'store'])
    ->name('quotations.store')
    ->middleware('auth');

Route::get('/quotations', [QuotationController::class, 'index'])
    ->name('quotations.index')
    ->middleware('auth');


//Route::get('/leads/pdf', [LeadController::class, 'downloadPdf'])->name('leads.pdf');
// Route::get('/quotations/pdf', [QuotationController::class, 'downloadPdf'])->name('quotations.pdf');

//    Route::get('/invoice/{id}/download', [QuotationController::class, 'downloadInvoice'])
// ->name('invoice.download');

// Route::get('/quotations/pdf', [QuotationController::class, 'downloadInvoice']);
Route::get('/quotations/{id}/download', [QuotationController::class, 'downloadInvoice'])
    ->name('invoice.download');

Route::resource('quotations', QuotationController::class);

Route::patch(
    'quotations/{quotation}/status',
    [QuotationController::class, 'updateStatus']
)
    ->name('quotations.updateStatus');


Route::middleware(['auth'])->group(function () {
    Route::get('/sales-persons', [SalesController::class, 'index'])
        ->name('sales.index');
});

Route::patch('/sales-persons/{user}/toggle', [SalesController::class, 'toggle'])
    ->name('sales.toggle')
    ->middleware('auth');

Route::post('/inquiry', [LeadController::class, 'websiteStore'])
    ->name('website.inquiry');

// Route::get('/profile', [ProfileController::class, 'show'])
//     ->middleware('auth')
//     ->name('profile.show');
