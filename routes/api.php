<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use Spatie\Permission\Middlewares\RoleMiddleware;


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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

    // Route::controller(App\Http\Controllers\AuthController::class)->group(function () {
    //     Route::post('login', 'login');
    //     Route::post('register', 'register');
    //     Route::post('logout', 'logout')->middleware('auth:sanctum');
    //     Route::post('forgot', 'forgot');
    //     Route::put('reset/{token}', 'reset')->name('reset.password.post');
    //     Route::get('/email/verify/{id}/{hash}', 'verify')
    //     ->name('verification.verify');
    // });
// Route::controller(App\Http\Controllers\BookController::class)->group(function () {
//     Route::post('books', 'index');

//     });
// Route::apiResource('books', BookController::class)->middleware(['auth:sanctum']);
// Route::apiResource('category', CategoryController::class)->middleware(['auth:sanctum','role:admin']);


// Route::apiResource('category', CategoryController::class)->middleware(['auth:sanctum','role:admin']);
// // Route::middleware([ 'role:admin', RoleMiddleware::class])->group(function () {
// // });

// Route::controller(CategoryController::class)->group(function () {
//     Route::get('category', 'index');
// })->middleware(['permission:edit book','auth:sanctum']);
Route::controller(App\Http\Controllers\BookController::class)->group(function () {
    Route::get('books', 'index')->middleware(['auth:sanctum','permission:list books']);
    Route::get('book/{id}', 'show')->middleware(['auth:sanctum','permission:list books']);
    Route::post('book', 'store')->middleware(['auth:sanctum','permission:add book']);
    Route::put('books/{id}', 'update')->middleware(['auth:sanctum','permission:edit book']);
    Route::delete('book/{id}', 'destroy')->middleware(['auth:sanctum','permission:delete book']);
    Route::get('book/category/{id}', 'filter')->middleware(['auth:sanctum','permission:filter books']);
});
Route::controller(App\Http\Controllers\BookController::class)->group(function () {
    Route::get('categories', 'index')->middleware(['auth:sanctum','permission:list categories']);
    Route::get('category/{id}', 'show')->middleware(['auth:sanctum','permission:list books']);
    Route::post('category', 'store')->middleware(['auth:sanctum','role:admin']);
    Route::put('category/{id}', 'update')->middleware(['auth:sanctum','role:admin']);
    Route::delete('category/{id}', 'destroy')->middleware(['auth:sanctum','role:admin']);
});
Route::post('manage/roles',[AuthController::class,'manageRoles']);
Route::post('manage/permissions', [AuthController::class, 'managePermissions']);
// Route::post('/resetpassword',[AuthController::class,'sendResetLinkEmail']);
// Route::post('manage/roles', [AuthController::class, 'manageRoles']);:

