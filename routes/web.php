<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubcriptionPlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\RasberryPiController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'welcome');

Route::group(['middleware' => 'check.subscription'], function () {
    Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);

Route::post('/post-rasberry-data/{id}', [RasberryPiController::class, 'postData'])->name('post-rasberry-data');

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {

        // Manage Subscription Plan
        Route::prefix('manage-subscription-plans')->group(function () {
            Route::get('', [SubcriptionPlanController::class, "view"])            
                ->name('subscription-plans.view');
    
            Route::get('create', [SubcriptionPlanController::class, "create"])            
                ->name('subscription-plans.create');
    
            Route::post('save', [SubcriptionPlanController::class, "save"])            
                ->name('subscription-plans.save');
    
            Route::get('edit/{id}', [SubcriptionPlanController::class, "edit"])            
                ->name('subscription-plans.edit');
    
            Route::get('delete/{id}', [SubcriptionPlanController::class, "delete"])            
                ->name('subscription-plans.delete');
    
            Route::delete('destroy/{id}', [SubcriptionPlanController::class, "destroy"])            
                ->name('subscription-plans.destroy');
        });

        // Manage User
        Route::prefix('manage-users')->group(function () {
            Route::get('', [UserController::class, "view"])            
                ->name('users.view');    
 
            Route::post('save', [UserController::class, "save"])            
                ->name('users.save');
    
            Route::get('edit/{id}', [UserController::class, "edit"])            
                ->name('users.edit');
    
            Route::get('delete/{id}', [UserController::class, "delete"])            
                ->name('users.delete');
    
            Route::delete('destroy/{id}', [UserController::class, "destroy"])            
                ->name('users.destroy');
        });

        // Manage User Subscriptions
        Route::prefix('user-subscription')->group(function () {
            Route::get('', [UserSubscriptionController::class, "view"])
                ->name('user-subscription.view');            
            Route::get('/checkout/success', [UserSubscriptionController::class, 'success'])
                ->name('user-subscription.success');
            Route::get('/checkout/cancel', [UserSubscriptionController::class, 'cancel'])
                ->name('user-subscription.cancel');
            Route::get('/checkout/{plan_id?}', [UserSubscriptionController::class, 'checkout'])
                ->name('user-subscription.checkout');
        });

        // Manage Subscription Plan
        Route::prefix('manage-rasberry-pi')->middleware('check.subscription')->group(function () {
            Route::get('', [RasberryPiController::class, "view"])            
                ->name('rasberry-pi.view');
    
            Route::get('create', [RasberryPiController::class, "create"])            
                ->name('rasberry-pi.create');
    
            Route::post('save', [RasberryPiController::class, "save"])            
                ->name('rasberry-pi.save');
    
            Route::get('edit/{id}', [RasberryPiController::class, "edit"])            
                ->name('rasberry-pi.edit');

            Route::get('connect/{id}', [RasberryPiController::class, "connect"])            
                ->name('rasberry-pi.connect');

            Route::get('details/{id}', [RasberryPiController::class, "details"])            
                ->name('rasberry-pi.details');
    
            Route::get('delete/{id}', [RasberryPiController::class, "delete"])            
                ->name('rasberry-pi.delete');
    
            Route::delete('destroy/{id}', [RasberryPiController::class, "destroy"])            
                ->name('rasberry-pi.destroy');
        });



    });
});
