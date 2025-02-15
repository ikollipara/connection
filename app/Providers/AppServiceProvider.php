<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('metadata', function () {
            $this->jsonb('metadata');
        });

        // @codeCoverageIgnoreStart
        Schedule::macro('hasCommand', function (string $command, string $expression): bool {
            $event = Arr::first(
                $this->events(),
                fn(Event $item): bool => Str::after($item->command ?? "", "'artisan' ") === $command && $item->expression === $expression
            );

            return ! is_null($event);
        });
        // @codeCoverageIgnoreEnd
    }
}
