<?php

namespace App\Console\Commands;

use App\Models\FrequentlyAskedQuestion;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class ListQuestions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "app:list-questions";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "List all unanswered questions.";

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
        $questions = FrequentlyAskedQuestion::query()
            ->unanswered()
            ->orderBy("created_at")
            ->select(["id", "title", "content"])
            ->get();
        $rows = $questions->map(
            fn(FrequentlyAskedQuestion $question) => [
                $question->id,
                $question->title,
                $question->content_excerpt,
            ],
        );
        $this->table(["ID", "Title", "Content"], $rows);
        return 0;
    }
}
