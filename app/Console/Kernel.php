<?php

namespace App\Console;

use App\Models\User;
use App\Notifications\QualtricsSurvey;
use App\Services\SurveyService;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule
            ->call(function () {
                User::query()
                    ->where("consented", true)
                    ->each(
                        fn($user) => (new SurveyService($user))
                            ->sendSurvey(
                                [SurveyService::CT_CAST],
                                SurveyService::ONCE,
                            )
                            ->sendSurvey(
                                [SurveyService::CT_CAST, SurveyService::SCALES],
                                SurveyService::YEARLY,
                            ),
                    );
            })
            ->daily();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . "/Commands");

        require base_path("routes/console.php");
    }
}
