<?php

use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Route;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::middleware('auth')->group(function () {  
    Route::resource('products', App\Http\Controllers\ProductController::class);
    Route::post('/order/{product}/buynow', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store.buynow');
    Route::get('/order/list', [App\Http\Controllers\OrderController::class, 'index'])->name('order.index');

    Route::get('/success/{order}', [App\Http\Controllers\OrderController::class, 'success'])->name('order.success');
    Route::get('/cancel/{order}', [App\Http\Controllers\OrderController::class, 'cancel'])->name('order.cancel');

});

Route::get('/', [App\Http\Controllers\ProductController::class, 'listing'])->name('order.listing');
