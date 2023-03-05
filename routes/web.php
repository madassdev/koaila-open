<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('/integrations', [App\Http\Controllers\IntegrationController::class, 'index'])->name('integrations');
    Route::get('/integrations-forms/{type}', [App\Http\Controllers\IntegrationController::class, 'create'])->name('integrations-forms');
    Route::post('/integrations-forms/{type}', [App\Http\Controllers\IntegrationController::class, 'store'])->name('create-integration');
    Route::get('/config', [App\Http\Controllers\ConfigurationController::class, 'index'])->name('configuration');
    Route::post('/config/{type}', [App\Http\Controllers\ConfigurationController::class, 'store'])->name('create-configuration');
    Route::get('/upsell-dashboard', [App\Http\Controllers\UpsellController::class, 'index'])->name('upsell-dashboard');
});
