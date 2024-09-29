<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Admin\AuthController;
use App\Http\Controllers\Api\Admin\ProfileController;
use App\Http\Controllers\Api\Admin\AdminsController;
use App\Http\Controllers\Api\Admin\RoleController;
use App\Http\Controllers\Api\Admin\PackageController;
use App\Http\Controllers\Api\Admin\FeatureController;
use App\Http\Controllers\Api\Admin\PaymentMethodController;
use App\Http\Controllers\Api\Admin\SettingController;
use App\Http\Controllers\Api\Admin_Front\Checkout\PaypalPaymentController;
use App\Http\Controllers\Api\Admin_Front\Checkout\StripePaymentController;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Admin_Front\HomeController;

foreach (config('tenancy.central_domains', []) as $domain) {

    Route::domain($domain)
        ->group(function () {

        Route::get('/user', function (Request $request) {
            return $request->user();
        })->middleware('auth:sanctum');

        Route::get('/profile/{user}', [ProfileController::class, 'index'])->middleware('auth:sanctum');
        Route::post('/update-profile/{user}', [ProfileController::class, 'updateProfile'])->middleware('auth:sanctum');

        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
        Route::post('/register', [AuthController::class, 'register']);

        Route::apiResource('admins', AdminsController::class)->middleware('auth:sanctum');
        Route::apiResource('roles', RoleController::class)->middleware('auth:sanctum');
        Route::apiResource('packages', PackageController::class)->middleware('auth:sanctum');
        Route::apiResource('features', FeatureController::class)->middleware('auth:sanctum');
        Route::apiResource('payment-methods', PaymentMethodController::class)->middleware('auth:sanctum');

        Route::get('/settings', [SettingController::class, 'index']);
        Route::post('/settings', [SettingController::class, 'store']);

        Route::get('/home-packages', [HomeController::class, 'getPackages']);

        Route::post('/create-tenant', [HomeController::class, 'create_tenant'])->middleware('auth:sanctum');

        // Route::get('/paypal-payment/{data}', [PaypalPaymentController::class, 'pay'])->middleware('auth:sanctum');
        Route::get('/paypal-success', [PaypalPaymentController::class, 'success'])->name('paypal.success');
        Route::get('/paypal-cancel', [PaypalPaymentController::class, 'cancel'])->name('paypal.cancel');


        // Route::get('/stripe-payment/{data}', [StripePaymentController::class, 'pay'])->middleware('auth:sanctum');
        // Route::get('/stripe-success', [StripePaymentController::class, 'success'])->middleware('auth:sanctum')->name('stripe.success');
        // Route::get('/stripe-cancel', [StripePaymentController::class, 'cancel'])->middleware('auth:sanctum')->name('stripe.cancel');
    });
}
