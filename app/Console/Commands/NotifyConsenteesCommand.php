<?php

declare(strict_types=1);

namespace App\Console\Commands;

use App\Models\User;
use App\Services\SurveyService;
use Illuminate\Console\Command;

final class NotifyConsenteesCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-consentees-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify consentees';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $users = User::query()->whereConsented(true)->get();
        foreach ($users as $user) {
            (new SurveyService($user))
                ->sendSurvey([SurveyService::CT_CAST], SurveyService::ONCE)
                ->sendSurvey([SurveyService::CT_CAST, SurveyService::SCALES], SurveyService::YEARLY);
        }
    }
}
