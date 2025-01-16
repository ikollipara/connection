<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Notifications\SurveyReminder;
use Illuminate\Console\Command;

class SendSurveyReminderCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-survey-reminder';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send out survey reminder to users who have not completed the survey.';

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
        User::query()
            ->where('consented', true)
            ->each(function (User $user) {
                $user->notify(new SurveyReminder($user));
                $this->info("Survey reminder sent to {$user->email}.");
            });

        return 0;
    }
}
