<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubcriptionPlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserSubscriptionController;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\RasberryPiController;
use App\Http\Controllers\RasberryPiModelController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;

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

Route::get("/", [HomeController::class, "view"])->name('home');

Route::group(['middleware' => ['check.subscription', 'check.trial.subscription']], function () {
    Route::get("dashboard", [DashboardController::class, "view"])->middleware(['auth', 'verified'])->name('dashboard');    
});

Route::get("dashboard/getCpuUsage/{hours}", [DashboardController::class, "getCpuUsage"])->name('dashboard.getCpuUsage');
Route::get("dashboard/getRamUsage/{hours}", [DashboardController::class, "getRamUsage"])->name('dashboard.getRamUsage');
Route::get("dashboard/getMonthlyRevenue/{months}", [DashboardController::class, "getMonthlyRevenue"])->name('dashboard.getMonthlyRevenue');

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

require __DIR__.'/auth.php';

Route::post('/stripe/webhook', [StripeController::class, 'handleWebhook']);

Route::post('/post-rasberry-data/{id}', [RasberryPiController::class, 'postData'])->name('post-rasberry-data');

Route::get('/setup-rasberry-pi/{token}', [RasberryPiController::class, 'setup'])->name('setup-rasberry-pi');

Route::get('lang/{locale}', function ($locale) {
    if (in_array($locale, ['en', 'fr'])) { // Add more languages as needed
        Session::put('locale', $locale);
        App::setLocale($locale);
    }
    return redirect()->back();
})->name('lang.switch');

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
        Route::prefix('manage-users')->middleware(['check.subscription', 'check.trial.subscription'])->group(function () {
            Route::get('', [UserController::class, "view"])            
                ->name('users.view');    

            Route::get('create', [UserController::class, "create"])            
                ->name('users.create');
 
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

        // Manage Rasberry Pi Modals
        Route::prefix('manage-rasberry-pi-modals')->group(function () {
            Route::get('', [RasberryPiModelController::class, "view"])            
                ->name('rasberry-pi-modal.view');
    
            Route::get('create', [RasberryPiModelController::class, "create"])            
                ->name('rasberry-pi-modal.create');
    
            Route::post('save', [RasberryPiModelController::class, "save"])            
                ->name('rasberry-pi-modal.save');
    
            Route::get('edit/{id}', [RasberryPiModelController::class, "edit"])            
                ->name('rasberry-pi-modal.edit');
    
            Route::get('delete/{id}', [RasberryPiModelController::class, "delete"])            
                ->name('rasberry-pi-modal.delete');
    
            Route::delete('destroy/{id}', [RasberryPiModelController::class, "destroy"])            
                ->name('rasberry-pi-modal.destroy');
        });

        // Manage Subscription Plan
        Route::prefix('manage-rasberry-pi')->middleware(['check.subscription', 'check.trial.subscription'])->group(function () {
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
