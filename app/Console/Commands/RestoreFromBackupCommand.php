<?php

declare(strict_types=1);

namespace App\Console\Commands;

use Arr;
use Illuminate\Console\Command;
use Illuminate\Contracts\Console\PromptsForMissingInput;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Process;

class RestoreFromBackupCommand extends Command implements PromptsForMissingInput
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:restore {file : The file to restore from} {--wipe}';

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
        if ($this->option('wipe')) Artisan::call('db:wipe');

        /** @var string */
        $file = $this->argument('file');

        $contents = Arr::join(file($file) ?? [], "\n");

        /** @var array{host: string, port: string, password: string|'', database: string, username: string} */
        $dbConfig = config('database.connections.mysql');

        $processArgs = [
            '-h' . $dbConfig['host'],
            '-u' . $dbConfig['username'],
            '-P' . $dbConfig['port']
        ];

        if (filled($dbConfig['password'])) $processArgs[] = '-p' . $dbConfig['password'];

        $result = Process::input($contents)->run(['mysql', ...$processArgs]);

        if ($result->failed()) {
            $this->error($result->errorOutput());
            $this->error("Failed to restore database.");
            return 1;
        };
        if ($result->successful()) {
            $this->info($result->output());
            $this->info("Successfully restored database");
            return 0;
        };
    }
}
