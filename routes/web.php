<?php

use App\Http\Controllers\Auth\AuthenticatedUserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ContentCollectionCommentController;
use App\Http\Controllers\ContentCollectionController;
use App\Http\Controllers\EventAttendeeController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\EventICalController;
use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\UserContentCollectionController;
use App\Http\Controllers\UserContentCollectionEntryController;
use App\Http\Controllers\UserContentCollectionPublishController;
use App\Http\Controllers\UserContentCollectionStatusController;
use App\Http\Controllers\UserEventController;
use App\Http\Controllers\UserFeedController;
use App\Http\Controllers\UserFollowerController;
use App\Http\Controllers\UserFollowingController;
use App\Http\Controllers\UserPostController;
use App\Http\Controllers\UserPostPublishController;
use App\Http\Controllers\UserPostStatusController;
use App\Http\Controllers\UserProfileController;
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

Route::view('/', 'index')->name('index')->middleware('guest');
Route::view('about', 'about')->name('about')->middleware('guest');
Route::get('contact', [ContactController::class, 'create'])->name('contact');
Route::post('contact', [ContactController::class, 'store']);

Route::get('auth/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('auth/register', [RegisteredUserController::class, 'store']);
Route::get('auth/login', [AuthenticatedUserController::class, 'create'])->name('login');
Route::post('auth/login', [AuthenticatedUserController::class, 'store']);
Route::get('auth/login/{user}', [AuthenticatedUserController::class, 'show'])->name('login.show');
Route::delete('auth/logout', [AuthenticatedUserController::class, 'destroy'])->name('logout');

Route::get('{user}/feed', UserFeedController::class)->name('user.feed');
Route::get('search', SearchController::class)->name('search');

// Post Routes
Route::addRoute(['POST', 'PUT'], 'users/{user}/posts/{post?}/publish', UserPostPublishController::class)->name('users.posts.publish');
Route::addRoute(['PATCH', 'DELETE'], 'users/{user}/posts/{post}/status', UserPostStatusController::class)->name('users.posts.status')->withTrashed();
Route::resource('users.posts', UserPostController::class)->withTrashed();
Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show')->withTrashed();
Route::resource('posts.comments', PostCommentController::class)->except(['create', 'edit']);

// Collection Routes
Route::addRoute(['POST', 'PUT'], 'users/{user}/collections/{collection?}/publish', UserContentCollectionPublishController::class)->name('users.collections.publish');
Route::addRoute(['PATCH', 'DELETE'], 'users/{user}/collections/{collection}/status', UserContentCollectionStatusController::class)->name('users.collections.status')->withTrashed();
Route::resource('users.collections', UserContentCollectionController::class)->withTrashed();
Route::get('collections/{collection}', [ContentCollectionController::class, 'show'])->name('collections.show')->withTrashed();
Route::resource('users.collections.entries', UserContentCollectionEntryController::class)->only(['destroy'])->withTrashed();
Route::resource('collections.comments', ContentCollectionCommentController::class)->except(['create', 'edit']);

// Event Routes
Route::get('/events/ical', EventICalController::class)->name('events.ical');
Route::resource('events', EventController::class)->only(['index', 'show']);
Route::resource('users.events', UserEventController::class)->except(['show']);
Route::apiResource('events.attendees', EventAttendeeController::class)->only(['store', 'destroy']);

// Profile Routes
Route::singleton('users.profile', UserProfileController::class);

// Following Routes
Route::resource('users.followers', UserFollowerController::class)->only(['store', 'destroy', 'index']);
Route::get('users/{user}/following', UserFollowingController::class)->name('users.following');
