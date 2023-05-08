<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['middleware' => 'guest:api'], function () {
    Route::post('oauth/{driver}', [\App\Http\Controllers\Auth\OAuthController::class, 'getUrl']);
    Route::get('oauth/{driver}/redirect', [\App\Http\Controllers\Auth\OAuthController::class, 'redirect']);
    Route::get('oauth/{driver}/callback', [\App\Http\Controllers\Auth\OAuthController::class, 'handleCallback'])->name('oauth.callback');
});

Route::post('data-mapping', [\App\Http\Controllers\API\CustomerController::class, 'store']);

