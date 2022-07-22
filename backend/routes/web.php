<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;

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

Route::group(['prefix' => 'admin', 'as' => 'admin.'], function(){
    /* USER */
    Route::get('/users', [UserController::class, 'index'])->name('users');
});

Route::group(['middleware' => 'auth'], function(){
    Route::get('/', [HomeController::class, 'index'])->name('index');

    /* POST */
    Route::get('/post/create', [Postcontroller::class, 'create'])->name('post.create');
    Route::post('/post/store', [Postcontroller::class, 'store'])->name('post.store');
    Route::get('/post/{id}/show', [Postcontroller::class, 'show'])->name('post.show');
    Route::get('/post/{id}/edit', [Postcontroller::class, 'edit'])->name('post.edit');
    Route::patch('/post/{id}/update', [Postcontroller::class, 'update'])->name('post.update');
    Route::delete('/post/{id}/destroy', [PostController::class, 'destroy'])->name('post.destroy');

    /* COMMENT */
    Route::post('/comment/{post_id}/store', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comment/{id}/destroy', [CommentController::class, 'destroy'])->name('comment.destroy');

    /* PROFILE */
    Route::get('/profile/{id}/show', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile/{id}/followers', [ProfileController::class, 'followers'])->name('profile.followers');
    Route::get('/profile/{id}/following', [ProfileController::class, 'following'])->name('profile.following');
    Route::get('/profile/show', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    /* LIKE */
    Route::post('/like/{post_id}/store', [LikeController::class, 'store'])->name('like.store');
    Route::delete('/like/{post_id}/destroy', [LikeController::class, 'destroy'])->name('like.destroy');

    /* FOLLOW */
    Route::post('/follow/{id}/store', [FollowController::class, 'store'])->name('follow.store');
    Route::delete('/follow/{id}/destroy', [FollowController::class, 'destroy'])->name('follow.destroy');

});
