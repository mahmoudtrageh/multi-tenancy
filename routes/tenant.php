<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\TenantDatabase;
use App\Http\Middleware\UniversalRoutes;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Tenant\Admin\AuthController;

Route::prefix('api')
    ->middleware([
        'api',
        InitializeTenancyByDomain::class,
        PreventAccessFromCentralDomains::class,
    ])
    ->group(function () {

        Route::get('/', function () {
            return response()->json(['message' => 'This is a tenant route']);
        });

        Route::group(['middleware' => 'auth:sanctum'], function () {
            Route::get('/user', function (Request $request) {
                return $request->user();
            });
        });

        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('/register', [AuthController::class, 'register']);

    });
