<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//Route::get('/products', function(){
//    return Product::all();
//});
//Route::post('/products', function(){
//    return Product::create([
//        'name' => 'Produkt pierwszy',
//        'description' => 'To jest przykladowy produkt',
//        'price' => '23.56'
//    ]);
//});
//Route::get('/products', [ProductController::class, 'index']);
//Route::post('/products', [ProductController::class, 'store']);

//Route::resource('products', ProductController::class);

//Trasy publiczne
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::get('/products/search/{name}', [ProductController::class, 'search']);

//Trasy chronione
Route::group(['middleware' => ['auth:sanctum']], function() {
    Route::post('/products', [ProductController::class, 'store']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::post('/login', [AuthController::class, 'login'])->name('login');
Route::post('/register', [AuthController::class, 'register'])->name('register');


