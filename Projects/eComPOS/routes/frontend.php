<?php

use App\Http\Controllers\Frontend\Auth\AuthenticationController;
use App\Http\Controllers\Frontend\HomeController;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationController::class)->group(function () {
    Route::get('signin', 'signin')->name('signin');
    Route::post('signin', 'signinRequest')->name('signin.request');
    Route::get('signup', 'signup')->name('signup');
    Route::post('signup', 'signupRequest')->name('signup.request');
    Route::get('/signup/varification/{token}', 'varification')->name('signup.varification');
});
Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'index')->name('home');
    Route::get('product-details/{slug}', 'productDetails');
    Route::get('ajax-product-details/{slug}', 'ajaxProductDetails');
    Route::get('checkout', 'checkout')->name('checkout');
    Route::get('profile', 'profile')->name('profile');
    Route::get('ajax-categories', 'categories');
    Route::get('ajax-new-products', 'newProducts');
    Route::get('ajax-big-sale-products', 'bigSaleProducts');
    Route::get('ajax-customer-choice-products', 'customerChoiceProducts');
    Route::get('ajax-best-deal-products', 'bestDealProducts');
    Route::get('ajax-banners', 'banners');
    Route::get('view-all-products/{type}/{slug}', 'viewAllProducts')->name('view.all.products');
    Route::get('ajax-view-all-products/{type}/{slug}', 'viewAllProductsAjax');
    Route::post('add-product-to-wishlist', 'addProductToWishlist');
    Route::post('add-product-to-cart', 'addProductToCart');
    Route::get('ajax-wishlist', 'ajaxWishlist');
    Route::get('ajax-carts', 'ajaxCarts');
    Route::post('ajax-carts-remove', 'ajaxCartsRemove');
    Route::post('ajax-wishlist-remove', 'ajaxWishlistRemove');
    Route::post('coupon-validate', 'couponValidate');
    Route::post('ajax-profile-update', 'ajaxProfileUpdate');
    Route::get('ajax-orders', 'myOrders');
});
Route::middleware(['auth'])->group(function () {
    Route::get('user/signout', [AuthenticationController::class, 'signout'])->name('user.signout');
});
