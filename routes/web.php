<?php

use App\Http\Controllers\EmailVerificationController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\FrequentlyAskedQuestionController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\PostCollectionsController;
use App\Http\Controllers\UserFollowersController;
use App\Http\Controllers\UserFollowingController;
use App\Http\Controllers\UserProfilesController;
use App\Http\Controllers\UsersController;
use App\Http\Controllers\UserSettingsController;
use App\Http\Controllers\WeeklyDigestSubscriptionController;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\User;
use App\Http\Livewire\Post;
use App\Http\Livewire\Collection;
use App\Http\Livewire\Home;
use App\Http\Livewire\Search;

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
    ->name("registration.create")
    ->middleware("guest");
Route::post("/users", [UsersController::class, "store"])->name(
    "registration.store",
);

Route::resource("login", LoginController::class)
    ->only(["create", "store", "show", "destroy"])
    ->parameter("login", "user")
    ->middleware("guest");

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
    Route::resource("faq", FrequentlyAskedQuestionController::class)->parameter(
        "faq",
        "question",
    );
    Route::get("/home", Home::class)->name("home");
    Route::get("/search", Search::class)
        ->name("search")
        ->middleware("verified");
    Route::resource("users", UsersController::class)->only([
        "edit",
        "update",
        "show",
    ]);
    Route::resource("users.followers", UserFollowersController::class)->only([
        "index",
    ]);
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

    // File Upload
    Route::post("/upload", [FileUploadController::class, "store"])
        ->name("upload.store")
        ->middleware("verified");
    Route::delete("/upload", [FileUploadController::class, "destroy"])
        ->name("upload.destroy")
        ->middleware("verified");

    // Post Routes
    Route::get("/posts", Post\Index::class)
        ->name("posts.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/create", Post\Editor::class)
        ->name("posts.create")
        ->middleware("verified");
    Route::get("/posts/{post}", [PostsController::class, "show"])
        ->name("posts.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{uuid}/edit", Post\Editor::class)
        ->name("posts.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/posts/{post}/comments", Post\Comments::class)
        ->name("posts.comments.index")
        ->withTrashed()
        ->middleware("verified");

    // Post Collection Routes
    Route::get("/collections/create", Collection\Editor::class)
        ->name("collections.create")
        ->middleware("verified");
    Route::get("/collections/{post_collection}", [
        PostCollectionsController::class,
        "show",
    ])
        ->name("collections.show")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections/{uuid}/edit", Collection\Editor::class)
        ->name("collections.edit")
        ->withTrashed()
        ->middleware("verified");
    Route::get("/collections", Collection\Index::class)
        ->name("collections.index")
        ->withTrashed()
        ->middleware("verified");
    Route::get(
        "/collections/{post_collection}/comments",
        Collection\Comments::class,
    )
        ->name("collections.comments.index")
        ->withTrashed()
        ->middleware("verified");
});
