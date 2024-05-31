<?php

namespace App\Console\Commands;

use App\Mail\WeeklyDigest;
use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendWeeklyDigest extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "app:send-weekly-digest {post?} {--post-of-the-week : A markdown file describing the post of the week.} {--E|extra= : A markdown file to include with the weekly digest.}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send the weekly digest to all users who have opted in to receive it.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $postId =
            $this->argument("post") ??
            $this->choice(
                "What Post?",
                Post::all(["id", "title"])
                    ->pluck("title", "id")
                    ->toArray(),
            );
        $postOfTheWeek = file_get_contents($this->option("post-of-the-week"));
        $extra = ($extra_filepath = $this->option("extra"))
            ? file_get_contents($extra_filepath)
            : "";
        User::query()
            ->where("receive_weekly_digest", true)
            ->each(function (User $user) use ($postId, $postOfTheWeek, $extra) {
                Mail::to($user)->send(
                    new WeeklyDigest(
                        $user,
                        [Post::find($postId), $postOfTheWeek],
                        $extra,
                    ),
                );
                $this->info("Sent weekly digest to {$user->email}.");
            });
        return 0;
    }
}
