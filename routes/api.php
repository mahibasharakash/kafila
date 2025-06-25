<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BoxController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GeneralSettingsController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TranslationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the Route Service Provider, and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('auth')->group(function () {
    Route::post('login', [AuthController::class, 'login'])->name('AUTH.LOGIN.API');
    Route::post('registration', [AuthController::class, 'registration'])->name('AUTH.REGISTRATION.API');
    Route::post('forgot', [AuthController::class, 'forgot'])->name('AUTH.FORGOT.API');
    Route::post('verification', [AuthController::class, 'verification'])->name('AUTH.VERIFICATION.API');
    Route::post('reset', [AuthController::class, 'reset'])->name('AUTH.RESET.API');
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::prefix('profile')->group(function () {
        Route::get('details', [AuthController::class, 'details'])->name('PROFILE.DETAILS.API');
        Route::put('change-password', [AuthController::class, 'changePassword'])->name('PROFILE.CHANGE.PASSWORD.API');
        Route::put('change-details', [AuthController::class, 'changeDetails'])->name('PROFILE.CHANGE.DETAILS.API');
        Route::post('logout', [AuthController::class, 'logout'])->name('PROFILE.LOGOUT.API');
    });

    Route::prefix('box')->group(function () {
        Route::delete('clear', [BoxController::class, 'clear'])->name('BOX.CLEAR.API');
        Route::get('', [BoxController::class, 'index'])->name('BOX.LIST.API');
        Route::post('', [BoxController::class, 'store'])->name('BOX.STORE.API');
        Route::get('{id}', [BoxController::class, 'show'])->name('BOX.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [BoxController::class, 'update'])->name('BOX.UPDATE.API');
        Route::delete('{id}', [BoxController::class, 'destroy'])->name('BOX.DESTROY.API');;
    });

    Route::prefix('category')->group(function () {
        Route::delete('clear', [CategoryController::class, 'clear'])->name('CATEGORY.CLEAR.API');
        Route::get('', [CategoryController::class, 'index'])->name('CATEGORY.LIST.API');
        Route::post('', [CategoryController::class, 'store'])->name('CATEGORY.STORE.API');
        Route::get('{id}', [CategoryController::class, 'show'])->name('CATEGORY.SHOW.API');
        Route::put('{id}', [CategoryController::class, 'update'])->name('CATEGORY.UPDATE.API');
        Route::delete('{id}', [CategoryController::class, 'destroy'])->name('CATEGORY.DESTROY.API');;
    });

    Route::prefix('brand')->group(function () {
        Route::delete('clear', [BrandController::class, 'clear'])->name('BRAND.CLEAR.API');
        Route::get('', [BrandController::class, 'index'])->name('BRAND.LIST.API');
        Route::post('', [BrandController::class, 'store'])->name('BRAND.STORE.API');
        Route::get('{id}', [BrandController::class, 'show'])->name('BRAND.SHOW.API');
        Route::put('{id}', [BrandController::class, 'update'])->name('BRAND.UPDATE.API');
        Route::delete('{id}', [BrandController::class, 'destroy'])->name('BRAND.DESTROY.API');;
    });

    Route::prefix('product')->group(function () {
        Route::delete('clear', [ProductController::class, 'clear'])->name('PRODUCT.CLEAR.API');
        Route::get('', [ProductController::class, 'index'])->name('PRODUCT.LIST.API');
        Route::post('', [ProductController::class, 'store'])->name('PRODUCT.STORE.API');
        Route::get('{id}', [ProductController::class, 'show'])->name('PRODUCT.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [ProductController::class, 'update'])->name('PRODUCT.UPDATE.API');
        Route::delete('{id}', [ProductController::class, 'destroy'])->name('PRODUCT.DESTROY.API');;
    });

    Route::prefix('blog')->group(function () {
        Route::delete('clear', [BlogController::class, 'clear'])->name('BLOG.CLEAR.API');
        Route::get('', [BlogController::class, 'index'])->name('BLOG.LIST.API');
        Route::post('', [BlogController::class, 'store'])->name('BLOG.STORE.API');
        Route::get('{id}', [BlogController::class, 'show'])->name('BLOG.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [BlogController::class, 'update'])->name('BLOG.UPDATE.API');
        Route::delete('{id}', [BlogController::class, 'destroy'])->name('BLOG.DESTROY.API');;
    });

    Route::prefix('service')->group(function () {
        Route::delete('clear', [ServiceController::class, 'clear'])->name('SERVICE.CLEAR.API');
        Route::get('', [ServiceController::class, 'index'])->name('SERVICE.LIST.API');
        Route::post('', [ServiceController::class, 'store'])->name('SERVICE.STORE.API');
        Route::get('{id}', [ServiceController::class, 'show'])->name('SERVICE.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [ServiceController::class, 'update'])->name('SERVICE.UPDATE.API');
        Route::delete('{id}', [ServiceController::class, 'destroy'])->name('SERVICE.DESTROY.API');;
    });

    Route::prefix('testimonial')->group(function () {
        Route::delete('clear', [TestimonialController::class, 'clear'])->name('SERVICE.CLEAR.API');
        Route::get('', [TestimonialController::class, 'index'])->name('SERVICE.LIST.API');
        Route::post('', [TestimonialController::class, 'store'])->name('SERVICE.STORE.API');
        Route::get('{id}', [TestimonialController::class, 'show'])->name('SERVICE.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [TestimonialController::class, 'update'])->name('SERVICE.UPDATE.API');
        Route::delete('{id}', [TestimonialController::class, 'destroy'])->name('SERVICE.DESTROY.API');;
    });

    Route::prefix('general-settings')->group(function () {
        Route::get('{id}', [GeneralSettingsController::class, 'show'])->name('GENERAL.SETTINGS.SHOW.API');
        Route::post('', [GeneralSettingsController::class, 'store'])->name('GENERAL.SETTINGS.STORE.API');
        Route::match(['put', 'patch'], '{id}', [GeneralSettingsController::class, 'update'])->name('GENERAL.SETTINGS.UPDATE.API');
    });

    Route::prefix('contact')->group(function () {
        Route::delete('clear', [ContactController::class, 'clear'])->name('CONTACT.CLEAR.API');
        Route::get('', [ContactController::class, 'index'])->name('CONTACT.LIST.API');
        Route::get('{id}', [ContactController::class, 'show'])->name('CONTACT.SHOW.API');
    });

    Route::prefix('customer')->group(function () {
        Route::delete('clear', [CustomerController::class, 'clear'])->name('CUSTOMER.CLEAR.API');
        Route::get('', [CustomerController::class, 'index'])->name('CUSTOMER.LIST.API');
        Route::get('{id}', [CustomerController::class, 'show'])->name('CUSTOMER.SHOW.API');
        Route::delete('{id}', [CustomerController::class, 'destroy'])->name('CUSTOMER.DESTROY.API');;
    });

    Route::prefix('review')->group(function () {
        Route::delete('clear', [ReviewController::class, 'clear'])->name('REVIEW.CLEAR.API');
        Route::get('', [ReviewController::class, 'index'])->name('REVIEW.LIST.API');
        Route::get('{id}', [ReviewController::class, 'show'])->name('REVIEW.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [ReviewController::class, 'update'])->name('REVIEW.UPDATE.API');
        Route::delete('{id}', [ReviewController::class, 'destroy'])->name('REVIEW.DESTROY.API');;
    });

    Route::prefix('order')->group(function () {
        Route::delete('clear', [OrderController::class, 'clear'])->name('ORDER.CLEAR.API');
        Route::get('', [OrderController::class, 'index'])->name('ORDER.LIST.API');
        Route::match(['put', 'patch'], '{id}', [OrderController::class, 'update'])->name('ORDER.UPDATE.API');
    });

    Route::prefix('translation')->group(function () {
        Route::delete('clear', [TranslationController::class, 'clear'])->name('TRANSLATION.CLEAR.API');
        Route::get('', [TranslationController::class, 'index'])->name('TRANSLATION.LIST.API');
        Route::post('', [TranslationController::class, 'store'])->name('TRANSLATION.STORE.API');
        Route::get('{id}', [TranslationController::class, 'show'])->name('TRANSLATION.SHOW.API');
        Route::match(['put', 'patch'], '{id}', [TranslationController::class, 'update'])->name('TRANSLATION.UPDATE.API');
        Route::delete('{id}', [TranslationController::class, 'destroy'])->name('TRANSLATION.DESTROY.API');;
    });

    Route::prefix('todo')->group(function () {
        Route::get('', [DashboardController::class, 'toDoIndex'])->name('TODO.LIST.API');
        Route::post('', [DashboardController::class, 'toDoCreate'])->name('TODO.STORE.API');
        Route::delete('{id}', [DashboardController::class, 'toDoDelete'])->name('TODO.DESTROY.API');;
        Route::match(['put', 'patch'], '{id}', [DashboardController::class, 'toDoStatus'])->name('TODO.UPDATE.API');
    });

    Route::get('visited-page', [DashboardController::class, 'visitIndex'])->name('PAGE.LIST.API');
    Route::get('social-media-source', [DashboardController::class, 'socialMediaTrafficIndex'])->name('SOCIAL.MEDIA.TRAFFIC.API');
    Route::get('total-resource', [DashboardController::class, 'totalCount'])->name('TOTAL.RESOURCE.API');
    Route::get('revenue-growth', [DashboardController::class, 'revenueGrowth'])->name('REVENUE.GROWTH.RESOURCE.API');

});

Route::prefix('contact')->group(function () {
    Route::post('store', [ContactController::class, 'store'])->name('CONTACT.STORE.API');
});

Route::get('general/{id}', [GeneralSettingsController::class, 'show'])->name('GENERAL.PAGE.API');
Route::get('box', [BoxController::class, 'index'])->name('BOX.LIST.API');
Route::get('category', [CategoryController::class, 'index'])->name('CATEGORY.LIST.API');
Route::prefix('blog')->group(function () {
    Route::get('', [BlogController::class, 'index'])->name('BLOG.LIST.API');
    Route::get('{id}', [BlogController::class, 'show'])->name('BLOG.SHOW.API');
});
Route::prefix('service')->group(function () {
    Route::get('', [ServiceController::class, 'index'])->name('SERVICE.LIST.API');
    Route::get('{id}', [ServiceController::class, 'show'])->name('SERVICE.SHOW.API');
});
Route::prefix('product')->group(function () {
    Route::get('', [ProductController::class, 'index'])->name('PRODUCT.LIST.API');
    Route::get('{id}', [ProductController::class, 'show'])->name('PRODUCT.SHOW.API');
});
Route::get('brand', [BrandController::class, 'index'])->name('BRAND.LIST.API');
Route::get('testimonial', [TestimonialController::class, 'index'])->name('TESTIMONIAL.LIST.API');
Route::prefix('review')->group(function () {
    Route::get('', [ReviewController::class, 'index'])->name('REVIEW.LIST.API');
    Route::post('store', [ReviewController::class, 'store'])->name('REVIEW.STORE.API');
});
Route::prefix('order')->group(function () {
    Route::get('', [OrderController::class, 'index'])->name('ORDER.LIST.API');
    Route::post('store', [OrderController::class, 'store'])->name('ORDER.STORE.API');
});
Route::post('visited-page/store', [DashboardController::class, 'visitStore'])->name('PAGE.STORE.API');
