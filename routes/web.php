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
    Route::get('/customer-dashboard/{id}', [App\Http\Controllers\CustomerController::class, 'show'])->name('customer-dashboard');
    Route::get('/upsell-historic-dashboard', [App\Http\Controllers\UpsellController::class, 'show'])->name('upsell-historic-dashboard');
    Route::post('/hide-customer-state/{customer_id}', [App\Http\Controllers\CustomerController::class, 'toggleVisibility'])->name('hide-customer-state');
    Route::get('/account-settings', [App\Http\Controllers\UserController::class, 'settings'])->name('settings.index');
    Route::post('/account-settings/personal-info', [App\Http\Controllers\UserController::class, 'savePersonalInfoSettings'])->name('settings.personalInfo.save');
    Route::post('/account-settings/email', [App\Http\Controllers\UserController::class, 'saveEmailSettings'])->name('settings.email.save');
    Route::post('/account-settings/password', [App\Http\Controllers\UserController::class, 'savePasswordSettings'])->name('settings.password.save');

    Route::group(['as'=>'oauth.'], function () {
        Route::get('oauth/{driver}/redirect', [\App\Http\Controllers\OAuth\OAuthController::class, 'redirect'])->name('redirect');
        Route::get('oauth/{driver}/callback', [\App\Http\Controllers\OAuth\OAuthController::class, 'handleCallback'])->name('callback');
    });
});

Route::get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});
