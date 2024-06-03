<?php

namespace App\Console\Commands;

use App\Models\FrequentlyAskedQuestion;
use Illuminate\Console\Command;

class AnswerQuestion extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "app:answer-question {id} {answer?}";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Answer a frequently asked question.";

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
        /** @var FrequentlyAskedQuestion */
        $question = FrequentlyAskedQuestion::findOrFail($this->argument("id"));
        if ($question->is_answered) {
            $this->error("This question has already been answered.");
            return 1;
        }
        $this->info("Question: {$question->title}");
        if ($question->content) {
            $this->info("Content: {$question->content}");
        }
        $answer =
            $this->argument("answer") ??
            $this->ask("What is the answer to the question?");
        if (
            $this->confirm(
                "Are you sure you want to answer the question: {$question->title}",
            )
        ) {
            $question->answer = $answer;
            $question->save();
            $this->info("The question has been answered.");
        }
        return 0;
    }
}
