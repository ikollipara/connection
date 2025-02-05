<?php

use App\Console\Commands\NotifyConsenteesCommand;
use App\Console\Kernel;
use Illuminate\Support\Facades\Schedule;

covers(Kernel::class);

it('should validate the schedule config', function () {
    $config = [
        (new NotifyConsenteesCommand)->getName() => '0 0 * * *',
        'queue:work --stop-when-empty' => '* * * * *'
    ];
    foreach ($config as $key => $value) {
        expect(Schedule::hasCommand($key, $value))->toBeTrue("$key => $value");
    }
});
