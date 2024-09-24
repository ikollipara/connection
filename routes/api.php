<?php

use App\Http\Controllers\Api\ContentContentCollectionController;
use App\Http\Controllers\Api\LikeLogController;
use App\Http\Controllers\Api\UserContentCollectionController;
use App\Http\Controllers\Api\UserPostController;
use App\Http\Controllers\FileUploadController;
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

Route::apiResource('users.posts', UserPostController::class)->only(['store', 'update']);
Route::apiResource('users.collections', UserContentCollectionController::class)->only(['store', 'update', 'index']);
Route::post('like', LikeLogController::class)->name('like');
Route::post('posts/{content}/collections', ContentContentCollectionController::class)->name('posts.collections.store');
Route::post('collections/{content}/collections', ContentContentCollectionController::class)->name('collections.collections.store');
Route::post('upload', [FileUploadController::class, 'store'])->name('upload.store');
Route::delete('upload', [FileUploadController::class, 'destroy'])->name('upload.destroy');
