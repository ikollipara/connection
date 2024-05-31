<?php

namespace App\Mail;

use App\Models\Post;
use App\Models\PostCollection;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class WeeklyDigest extends Mailable
{
    use Queueable, SerializesModels;

    public User $user;
    public string $week;
    public string $extra;
    public $topPostsOfTheWeek;
    public $topCollectionsOfTheWeek;
    public $postOfTheWeek;
    public $unsubscribeLink;
    public $randomPostOfTheWeek;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($user, $postOfTheWeek, $extra = null)
    {
        $this->unsubscribeLink = URL::signedRoute("weekly-digest.unsubscribe", [
            "user" => $user,
        ]);
        $this->postOfTheWeek = $postOfTheWeek;
        $this->randomPostOfTheWeek = Post::query()
            ->inRandomOrder()
            ->first();
        $this->postOfTheWeek[1] = Str::markdown($this->postOfTheWeek[1]);
        $this->extra = is_null($extra) ? "" : Str::markdown($extra);
        $this->user = $user;
        $this->week =
            now()
                ->startOfWeek()
                ->format("Y F j") .
            " - " .
            now()
                ->endOfWeek()
                ->format("F j");

        $this->topPostsOfTheWeek = Post::query()
            ->whereBetween("created_at", [
                now()->startOfWeek(),
                now()->endOfWeek(Carbon::FRIDAY),
            ])
            ->withCount("comments")
            ->orderBy("views", "desc")
            ->orderBy("likes_count", "desc")
            ->orderBy("comments_count", "desc")
            ->limit(5)
            ->get();

        $this->topCollectionsOfTheWeek = PostCollection::query()
            ->whereBetween("created_at", [
                now()->startOfWeek(),
                now()->endOfWeek(),
            ])
            ->withCount("comments")
            ->orderBy("views", "desc")
            ->orderBy("likes_count", "desc")
            ->orderBy("comments_count", "desc")
            ->limit(5)
            ->get();
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown("mail.weekly-digest");
    }
}
