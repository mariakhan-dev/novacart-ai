<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AIController;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\StripeController;
use App\Http\Controllers\FavoriteController;

Route::get('/login', [AuthController::class,'showLogin'])->name('login');
Route::post('/login', [AuthController::class,'login']);

Route::get('/register', [AuthController::class,'showRegister'])->name('register');
Route::post('/register', [AuthController::class,'register']);

Route::post('/logout', [AuthController::class,'logout'])->name('logout');
// ================= SHOP =================
Route::get('/', [ProductController::class, 'shop'])->name('shop');
Route::get('/shop', [ProductController::class, 'shop'])->name('shop.index');
Route::get('/product/{product}', [ProductController::class, 'show'])->name('product.show');
Route::get('/category/{category}', [ProductController::class, 'category'])->name('category.show');

// Cart
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{product}', [CartController::class, 'store'])->name('cart.store');
Route::delete('/cart/remove/{id}', [CartController::class, 'destroy'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
    Route::post('/checkout', [CartController::class, 'placeOrder'])->name('cart.placeOrder');
});
Route::middleware('auth')->group(function () {
    Route::get('/my-orders', [CartController::class, 'myOrders'])
    ->name('orders.my');
    Route::post('/order-whatsapp',
        [CartController::class, 'orderViaWhatsApp'])
        ->name('order.whatsapp');

});
Route::get('/cart/increase/{id}', [CartController::class,'increase'])->name('cart.increase');
Route::get('/cart/decrease/{id}', [CartController::class,'decrease'])->name('cart.decrease');

Route::middleware('auth')->group(function () {

    Route::post('/favorite/{product}', [FavoriteController::class, 'toggle'])
        ->name('favorite.toggle');

});

// ================= ADMIN =================
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {

    Route::get('/products', [ProductController::class, 'index'])->name('products.index');

    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products', [ProductController::class, 'store'])->name('products.store');

    Route::get('/products/{product}', [ProductController::class, 'showAdmin'])->name('products.show');

    Route::get('/products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');

    Route::put('/products/{product}', [ProductController::class, 'update'])->name('products.update');

    Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');

    Route::resource('categories', CategoryController::class);

    Route::get('/orders', [CartController::class, 'allOrders'])->name('orders');

    Route::get('/categories/{category}/products', [CartController::class, 'adminCategoryProducts'])
        ->name('category.products');

    Route::post('/orders/{order}/status', [CartController::class, 'updateOrderStatus'])
        ->name('orders.updateStatus');

});

Route::post('/ai/chat',[AIController::class,'chat'])->name('ai.chat');

Route::get('/test-ai', function () {

    $response = Http::withToken(env('GROQ_API_KEY'))
        ->post('https://api.groq.com/openai/v1/chat/completions', [
            'model' => 'llama-3.1-8b-instant',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => 'Hello'
                ]
            ]
        ]);

    return $response->json();

});

Route::get('/stripe/checkout', [StripeController::class,'checkout'])
    ->name('stripe.checkout');

Route::get('/stripe/success', [StripeController::class, 'success'])
    ->name('stripe.success');

Route::get('/stripe/cancel', [StripeController::class, 'cancel'])
    ->name('stripe.cancel');