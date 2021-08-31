<?php

use App\Http\Middleware\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


// Route::post('login',  [App\Http\Controllers\Admin\Auth\AuthController::class, 'login'])->name('admin.login');
// Route::post('register', [App\Http\Controllers\Admin\Auth\AuthController::class, 'register']);
// Route::get('logout',  [App\Http\Controllers\Admin\Auth\AuthController::class, 'logout'])->name('admin.logout');
// Route::get('/login',  function () {
//     return view('Layout.LoginAdmin');
// })->name('login');


// Route::post('login',  [App\Http\Controllers\Admin\Auth\AuthController::class, 'login']);
// Route::post('register', [App\Http\Controllers\Admin\Auth\AuthController::class, 'register']);

// Route::post('/send-mail', [App\Http\Controllers\Admin\Auth\AuthController::class, 'sendMail'])->name('forgot');
// Route::get('/forgot-password-complete', [App\Http\Controllers\Admin\Auth\AuthController::class, 'forgot_password_complete'])->name('forgotPasswordComplete');
// Route::get('/reset-password/{email}/{token}',  [App\Http\Controllers\Admin\Auth\AuthController::class, 'getToken'])->name('getToken');


// Route::middleware([Admin::class])->prefix('/admin')->group(function () {
//     Route::get('/', [App\Http\Controllers\Admin\HomeController::class, 'index'])->name('admin.home');
//     Route::resource('posts', 'Admin\PostController');
//     Route::resource('products', 'Admin\ProductController');
//     Route::get('fill_product', 'Admin\ProductController@create');
//     Route::resource('categories', 'Admin\CategoryController');
//     Route::resource('weights', 'Admin\WeightController');
//     Route::resource('descriptions', 'Admin\DescriptionController');
//     // Route::get('show', [AuthController::class, 'show']);
//     // Route::get('changePassWord', [AuthController::class, 'changePassWord']);
// });