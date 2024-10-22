<?php

use Illuminate\Support\Facades\Route;
use Stancl\Tenancy\Middleware\InitializeTenancyByDomain;
use Stancl\Tenancy\Middleware\PreventAccessFromCentralDomains;
use App\Http\Middleware\TenantDatabase;
use App\Http\Middleware\UniversalRoutes;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Tenant\Admin\AuthController;
use App\Http\Controllers\Api\Tenant\Admin\ProfileController;
use App\Http\Controllers\Api\Tenant\Front\HomeController;

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

        Route::get('/profile/{user}', [ProfileController::class, 'index'])->middleware('auth:sanctum');
        Route::post('/update-profile/{user}', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');

        Route::get('/home/products', [HomeController::class, 'getProducts']);
        Route::get('/home/categories', [HomeController::class, 'getCategories']);
        Route::get('/home/brands', [HomeController::class, 'getBrands']);
    });
