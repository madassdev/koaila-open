<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('auth/login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/integrations', [App\Http\Controllers\IntegrationController::class, 'index'])->name('integrations');
    Route::get('/integrations-forms/{type}', [App\Http\Controllers\IntegrationController::class, 'create'])->name('integrations-forms');
    Route::post('/integrations-forms/{type}', [App\Http\Controllers\IntegrationController::class, 'store'])->name('create-integration');
    Route::get('/config', [App\Http\Controllers\ConfigurationController::class, 'index'])->name('configuration');
    Route::post('/config', [App\Http\Controllers\ConfigurationController::class, 'store'])->name('create-configuration');
    Route::get('/upsell-dashboard', [App\Http\Controllers\UpsellController::class, 'index'])->name('upsell-dashboard');
    Route::get('/upsell-download', [App\Http\Controllers\UpsellController::class, 'download'])->name('upsell-download');
    Route::get('/upsell-send-emails', [App\Http\Controllers\UpsellController::class, 'sendUpsellEmails'])->name('upsell-send-emails');
    Route::get('/api-configuration', [App\Http\Controllers\ConfigurationController::class, 'getUUID'])->name('api-configuration');
    Route::get('/customer-dashboard/{email}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer-dashboard');
    Route::get('/upsell-historic-dashboard', [App\Http\Controllers\UpsellController::class, 'show'])->name('upsell-historic-dashboard.blade.php');
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
