<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/post/{post}', [App\Http\Controllers\PostController::class, 'show'])->name('post');


Route::middleware('auth')->group(function (){

    Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/post/create', [App\Http\Controllers\PostController::class, 'create'])->name('admin.post.create');
    Route::post('/admin/post/create', [App\Http\Controllers\PostController::class, 'store'])->name('admin.post.store');
    Route::get('/admin/posts/index', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');

    Route::delete('/admin/posts/{post}/delete', [App\Http\Controllers\PostController::class, 'delete'])->name('posts.delete');
    Route::delete('/admin/posts/{post}/edit', [App\Http\Controllers\PostController::class, 'edit'])->name('posts.edit');


});

