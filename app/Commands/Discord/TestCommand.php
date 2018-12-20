<?php

namespace App\Commands\Discord;

use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;
use App\Notifications\TestNotification;

class TestCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'discord:test';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Send Test Message';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Notification::route('discord', config('services.discord.channel'))
                    ->notify(new TestNotification('test'));

        Storage::put('test.txt', 'test');
    }

    /**
     * Define the command's schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule $schedule
     *
     * @return void
     */
    public function schedule(Schedule $schedule): void
    {
        // $schedule->command(static::class)->everyMinute();
    }
}
