<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\{PropertyController,AuthController,BlogController,InquiryController,WishlistController};

Route::prefix('v1')->group(function () {

    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login']);
    // Protected
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('/user', [AuthController::class, 'user']);
        Route::post('/update-profile', [AuthController::class, 'updateProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
    });
    // Property End Point
    Route::get('/properties', [PropertyController::class, 'index']);
    Route::get('/properties/{id}', [PropertyController::class, 'show'])->where('id', '[0-9]+');;
    Route::get('/properties/{slug}',[PropertyController::class,'showBySlug']);
    // Blog End Point
    Route::get('/blogs', [BlogController::class, 'index']);
    Route::get('/blogs/{slug}', [BlogController::class, 'show']);
    // Inquiry End Point
    Route::post('/inquiries', [InquiryController::class, 'store']);
    // Wishlist
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/wishlist/add', [WishlistController::class, 'add']);
        Route::post('/wishlist/remove', [WishlistController::class, 'remove']);
        Route::get('/wishlist', [WishlistController::class, 'list']);
    });

});
