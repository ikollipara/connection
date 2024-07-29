<?php

use App\Http\Controllers\EventAttendeeController;
use App\Http\Controllers\CommentCommentLikesController;
use App\Http\Controllers\ContentLikesController;
use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FrequentlyAskedQuestionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostCollectionEntriesController;
use App\Http\Controllers\PostCollectionsCommentsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostCollectionsController;
use App\Http\Controllers\PostsCommentsController;
use App\Http\Handlers\ContentSearchHandler;
use App\Http\Handlers\UpdateUserConsentHandler;
use App\Http\Controllers\UserFollowersController;
use App\Http\Controllers\UserFollowingController;
use App\Http\Controllers\UserPostCollectionsController;
use App\Http\Controllers\UserPostsController;
use App\Http\Controllers\UserProfilesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\WeeklyDigestSubscriptionController;
use App\Http\Handlers\CollectionsEntryHandler;
use App\Http\Handlers\DashboardHandler;
use App\Http\Controllers\EventController;
use App\Http\Handlers\ICalHandler;
use App\Http\Controllers\UserEventController;
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

Route::view("/", "home")->name("index");
Route::view("/about", "about")->name("about");
Route::view("/videos", "videos")->name("videos");

if (env("APP_DEBUG")) {
    Route::get("/mail", function () {
        return new App\Mail\WeeklyDigest(auth()->user(), [
            \App\Models\Post::first(),
            "This is a test.",
        ]);
    });
}

Route::get("/sign-up", [UsersController::class, "create"])
    ->name("users.create")
    ->middleware("guest");
Route::post("/users", [UsersController::class, "store"])->name("users.store");

Route::resource("login", LoginController::class)
    ->only(["create", "store", "show"])
    ->parameter("login", "user")
    ->middleware("guest");

Route::delete("/logout", [LoginController::class, "destroy"])
    ->name("login.destroy")
    ->middleware("auth");

Route::get("/email/verify/{id}/{hash}", [
    EmailVerificationController::class,
    "verify",
])
    ->name("verification.verify")
    ->middleware(["auth"]);
Route::get("/email/verify", [EmailVerificationController::class, "index"])
    ->name("verification.notice")
    ->middleware(["auth"]);

Route::delete("/weekly-digest/subscription/{user}", [
    WeeklyDigestSubscriptionController::class,
    "destroy",
])
    ->name("weekly-digest.subscription.destroy")
    ->middleware("signed");

Route::middleware("auth")->group(function () {
    // Event Routes
    //Index (calendar)
    Route::get('/events', [EventController::class, 'index'])
        ->name('events.index');
    Route::get("users/{user}/events", [UserEventController::class, "index"])
        ->name("users.events.index");
    // Create
    Route::get("/users/{user}/events/create", [UserEventController::class,"create"])
        ->name("users.events.create");
    // Show
    Route::get("/events/{event}/show", [EventController::class,"show"])
        ->name("events.show");
    // Edit
    Route::get("/users/{user}/events/{event}/edit", [
        UserEventController::class,
        "edit",
    ])
        ->name("users.events.edit")
        ->withTrashed()
        ->middleware("verified");
    // store
    Route::post('/users/{user}/events', [UserEventController::class,"store"])
        ->name("users.events.store")
        ->middleware("verified");
    // Update
    Route::patch("/users/{user}/events/{event}", [
        UserEventController::class,
        "update",
    ])
        ->name("users.events.update")
        ->withTrashed()
        ->middleware("verified");
    // Delete
    Route::delete("/users/{user}/events/{event}", [
        UserEventController::class,
        "destroy",
    ])
        ->name("users.events.destroy")
        ->withTrashed()
        ->middleware("verified");
    Route::get('/user/{user}/events/ical', ICalHandler::class)
        ->name('events.ical');
    // Attendees
    Route::post("/events/{event}/attendee", [EventAttendeeController::class,"store"])
        ->name("events.attendee.store")
        ->middleware("verified");
    // Route::post("events/{event}/attendee",function($event)
    // {
    //     dd('hello');
    // })
    //     ->name('events.attendee.store');


    Route::delete("/attendee/{attendee}", [EventAttendeeController::class,"destroy"])
        ->name("events.attendee.destroy");

    Route::post("/content/{content}/likes", [
        ContentLikesController::class,
        "store",
    ])
        ->name("content.likes.store")
        ->middleware("verified");

    Route::delete("/content/{content}/likes/{contentLike}", [
        ContentLikesController::class,
        "destroy",
    ])
        ->name("content.likes.destroy")
        ->middleware("verified");
    Route::resource("faq", FrequentlyAskedQuestionController::class)->parameter(
        "faq",
        "question",
    );
    Route::post("/entries", CollectionsEntryHandler::class)
        ->name("entries.toggle")
        ->middleware("verified");
    Route::get("/dashboard", DashboardHandler::class)->name("dashboard");
    Route::redirect("/home", "/dashboard")->name("home");
    Route::get("/search", ContentSearchHandler::class)
        ->name("search")
        ->middleware("verified");
    Route::resource("users", UsersController::class)->only([
        "edit",
        "update",
        "show",
        "destroy",
    ]);
    Route::get("/users/{user}/followers", [
        UserFollowersController::class,
        "index",
    ])
        ->name("users.followers.index")
        ->middleware("verified");
    Route::post("/users/{user}/followers", [
        UserFollowersController::class,
        "store",
    ])
        ->name("users.followers.store")
        ->middleware("verified");

    Route::delete("/users/{user}/followers/{follower}", [
        UserFollowersController::class,
        "destroy",
    ])
        ->name("users.followers.destroy")
        ->middleware("verified");
    Route::resource("users.following", UserFollowingController::class)->only([
        "index",
    ]);
    Route::get("/users/{user}/profile/edit", [
        UserProfilesController::class,
        "edit",
    ])
        ->name("users.profile.edit")
        ->middleware("verified");
    Route::patch("/users/{user}/profile", [
        UserProfilesController::class,
        "update",
    ])
        ->name("users.profile.update")
        ->middleware("verified");
    Route::get("/users/{user}/settings/edit", [
        UserSettingsController::class,
        "edit",
    ])
        ->name("users.settings.edit")
        ->middleware("verified");
    Route::patch("/users/{user}/settings", [
        UserSettingsController::class,
        "update",
    ])
        ->name("users.settings.update")
        ->middleware("verified");

    Route::patch("/users/{user}/consent", UpdateUserConsentHandler::class)
        ->name("users.consent.update")
        ->middleware("verified");

    // File Upload
    Route::post("/upload", [FileUploadController::class, "store"])
        ->name("upload.store")
        ->middleware("verified");
    Route::delete("/upload", [FileUploadController::class, "destroy"])
        ->name("upload.destroy")
        ->middleware("verified");

    // Post Routes
    Route::resource("users.posts", UserPostsController::class)->only([
        "create",
        "store",
    ]);
    Route::get("/users/{user}/posts/{post}/edit", [
        UserPostsController::class,
        "edit",
    ])
        ->name("users.posts.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/users/{user}/posts", [UserPostsController::class, "index"])
        ->name("users.posts.index")
        ->middleware("verified");
    Route::patch("/users/{user}/posts/{post}", [
        UserPostsController::class,
        "update",
    ])
        ->name("users.posts.update")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}", [PostsController::class, "show"])
        ->name("posts.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}/comments", [
        PostsCommentsController::class,
        "index",
    ])
        ->name("posts.comments.index")
        ->withTrashed()
        ->middleware("verified");
    Route::post("/posts/{post}/comments", [
        PostsCommentsController::class,
        "store",
    ])
        ->name("posts.comments.store")
        ->middleware("verified");

    // Post Collection Routes
    Route::resource("users.collections", UserPostCollectionsController::class)
        ->parameter("collection", "post_collection")
        ->only(["create", "store"]);
    Route::get("/users/{user}/collections/{post_collection}/edit", [
        UserPostCollectionsController::class,
        "edit",
    ])
        ->name("users.collections.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/users/{user}/collections", [
        UserPostCollectionsController::class,
        "index",
    ])
        ->name("users.collections.index")
        ->withTrashed()
        ->middleware("verified");
    Route::patch("/users/{user}/collections/{post_collection}", [
        UserPostCollectionsController::class,
        "update",
    ])
        ->name("users.collections.update")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{post_collection}", [
        PostCollectionsController::class,
        "show",
    ])
        ->name("collections.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{post_collection}/comments", [
        PostCollectionsCommentsController::class,
        "index",
    ])
        ->name("collections.comments.index")
        ->withTrashed()
        ->middleware("verified");

    Route::post("/collections/{post_collection}/entries", [
        PostCollectionEntriesController::class,
        "store",
    ])
        ->name("collections.entries.store")
        ->middleware("verified");

    Route::delete("/collections/{post_collection}/entries/{entry}", [
        PostCollectionEntriesController::class,
        "destroy",
    ])
        ->name("collections.entries.destroy")
        ->middleware("verified");

    Route::post("/collections/{post_collection}/comments", [
        PostCollectionsCommentsController::class,
        "store",
    ])
        ->name("collections.comments.store")
        ->middleware("verified");

    Route::post("/comments/{comment}/likes", [
        CommentCommentLikesController::class,
        "store",
    ])
        ->name("comments.likes.store")
        ->middleware("verified");

    Route::delete("/comments/{comment}/likes/{commentLike}", [
        CommentCommentLikesController::class,
        "destroy",
    ])
        ->name("comments.likes.destroy")
        ->middleware("verified");
});
