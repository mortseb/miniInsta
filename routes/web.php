<?php

use App\Http\Controllers\FollowController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;

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


Route::get('/', [HomepageController::class, 'index']);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');




Route::middleware('auth')->group(function () {
    Route::get('/posts', [PostsController::class, 'index'])->name('posts.index');
    Route::get('/posts/{id}', [PostsController::class, 'show'])->name('posts.show');
    Route::post('/posts', [PostsController::class, 'store'])->name('posts.store');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::patch('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar.update');
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

    Route::post('/posts/{posts}/comments', [PostsController::class, 'addComment'])->name('posts.comments.add');
    Route::delete('/posts/{posts}/comments/{comment}', [PostsController::class, 'deleteComment'])->name('posts.comments.delete');
    Route::get('/search',  [SearchController::class, 'search'])->name('search.results');
    Route::post('/posts/{post}/likes', [LikeController::class, 'like'])->name('posts.like');
    Route::delete('/posts/{post}/likes', [LikeController::class, 'unlike'])->name('posts.unlike');
    Route::post('/users/{user}/follow', [FollowController::class, 'follow'])->name('users.follow');
    Route::delete('/users/{user}/follow', [FollowController::class, 'unfollow'])->name('users.unfollow');
});

require __DIR__ . '/auth.php';
