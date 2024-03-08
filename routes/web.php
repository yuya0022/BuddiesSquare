<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\TradeController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    //メイン写真
    Route::put('/main_image', [ProfileController::class, 'main_image_update']);
    
    //サブ写真
    Route::post('/sub_images', [ProfileController::class, 'sub_image_store']);
    Route::put('/sub_images/{sub_image}', [ProfileController::class, 'sub_image_update']);
    Route::delete('/sub_images/{sub_image}', [ProfileController::class, 'sub_image_delete']);
});


//PostControllerに関わるルーティング
Route::controller(PostController::class)->middleware(['auth'])->group(function(){
    Route::get('/posts', 'index')->name('post.index');
    Route::post('/posts', 'store');
    Route::get('/posts/{post}', 'showDetail');
    Route::post('/posts/{post}', 'comment');
    Route::put('/posts/{post}', 'update');
    Route::delete('/posts/{post}', 'delete');
    Route::get('/posts/{post}/edit', 'edit');
    Route::get('/posts/{event}/{category}', 'show');
    Route::delete('/posts/comments/{comment}', 'commentDelete');
    Route::get('/posts/{event}/{category}/create', 'create');
});

//TradeControllerに関わるルーティング
Route::controller(TradeController::class)->middleware(['auth'])->group(function(){
    Route::get('/trades', 'index')->name('trade.index');
    Route::post('/trades', 'store');
    Route::get('/trades/create', 'create');
    Route::get('/trades/{trade}', 'show');
    Route::put('/trades/{trade}', 'update');
    Route::delete('/trades/{trade}', 'delete');
    Route::get('/trades/{trade}/edit', 'edit');
});



require __DIR__.'/auth.php';