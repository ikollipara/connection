<?php

declare(strict_types=1);

use App\Console\Commands\RestoreFromBackupCommand;
use Illuminate\Process\ProcessResult;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

covers(RestoreFromBackupCommand::class);


it('should restore the database based on the backup file', function () {
    $stream = fopen("testfile", "w");
    fwrite($stream, "", 0);
    fclose($stream);

    $result = Artisan::call('db:restore', ['file' => 'testfile']);

    expect($result)->toEqual(0);

    unlink("testfile");
});

it('should fail to restore the database based on the backup file', function () {
    $stream = fopen("testfile", "w");
    fwrite($stream, "Invalid Sql");
    fclose($stream);

    $result = Artisan::call('db:restore', ['file' => 'testfile']);


    expect($result)->toEqual(1);

    unlink("testfile");
});
