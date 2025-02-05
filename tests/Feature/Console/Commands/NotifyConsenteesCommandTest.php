<?php

use App\Console\Commands\NotifyConsenteesCommand;
use App\Mail\Survey;
use App\Models\User;

covers(NotifyConsenteesCommand::class);

it('should queue 2 surveys', function () {
    Mail::fake();
    User::factory()->consented()->createOne();

    Artisan::call(NotifyConsenteesCommand::class);
    Mail::assertQueued(Survey::class);
});
