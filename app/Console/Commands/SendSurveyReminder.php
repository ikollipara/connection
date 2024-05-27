<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SurveyReminder;
use Illuminate\Console\Command;

class SendSurveyReminder extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "app:send-survey-reminder";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Send out survey reminder to users who have not completed the survey.";

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
        /** @var int */
        $emails_sent = 0;
        User::query()
            ->where("consented", true)
            ->each(function (User $user) use ($emails_sent) {
                $user->notify(new SurveyReminder($user));
                $emails_sent++;
            });
        $this->info("Sent {$emails_sent} survey reminders.");
        return 0;
    }
}
