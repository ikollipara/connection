<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Process\Process;

class RestoreFromBackupCommand extends Command
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
            $config = config('database.connections.mysql');
            if ($password = $config['password']) {
                $process = new Process([
                    'mysql',
                    '-h'.$config['host'],
                    '-u'.$config['username'],
                    '-p'.$password,
                    '-P'.$config['port'],
                    $config['database'],
                ]);
            } else {
                $process = new Process([
                    'mysql',
                    '-h'.$config['host'],
                    '-u'.$config['username'],
                    '-P'.$config['port'],
                    $config['database'],
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
