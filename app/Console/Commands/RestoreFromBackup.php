<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class RestoreFromBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file} {--wipe}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Restore the database from a backup sql file';

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
        if ($this->option('wipe')) {
            Artisan::call('db:wipe');
        }
        if ($file = $this->argument('file')) {
            $stream = fopen($file, 'r');
            if ($password = env('DB_PASSWORD')) {
                $process = new Process([
                    'mysql',
                    '-h'.env('DB_HOST'),
                    '-u'.env('DB_USERNAME'),
                    '-p'.$password,
                    '-P'.env('DB_PORT'),
                    env('DB_DATABASE'),
                ]);
            } else {
                $process = new Process([
                    'mysql',
                    '-h'.env('DB_HOST'),
                    '-u'.env('DB_USERNAME'),
                    '-P'.env('DB_PORT'),
                    env('DB_DATABASE'),
                ]);
            }
            $process->setInput($stream);
            try {
                $process->mustRun(function ($type, $buffer) {
                    if ($type === Process::ERR) {
                        $this->error($buffer);
                    } else {
                        $this->info($buffer);
                    }
                });
                $this->info('Database restored from '.$file);

                return 0;
            } catch (\Throwable $th) {
                $this->error(
                    'Failed to restore database from '.
                        $file.
                        '. Error:'.
                        PHP_EOL.
                        $th->getMessage(),
                );

                return 1;
            }
        }
        $this->error('No file specified');

        return 1;
    }
}
