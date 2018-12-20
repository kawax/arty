<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Discord\DiscordManager;
use RestCord\DiscordClient;

class DiscordServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(DiscordManager::class, function ($app) {
            return new DiscordManager;
        });

        $this->app->singleton(DiscordClient::class, function ($app) {
            return new DiscordClient([
                'token' => config('services.discord.token'),
            ]);
        });
    }
}
