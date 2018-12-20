<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Discord\DiscordManager;
use RestCord\DiscordClient;
use React\EventLoop\Factory;
use CharlotteDunois\Yasmin\Client;

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
        $this->app->singleton(DiscordManager::class, function () {
            return new DiscordManager(
                $this->app['config']->get('services.discord')
            );
        });

        $this->app->singleton(DiscordClient::class, function () {
            return new DiscordClient([
                'token' => $this->app['config']->get('services.discord.token'),
            ]);
        });

        $this->app->singleton(Client::class, function () {
            return new Client(
                $this->app['config']->get('services.discord.yasmin'),
                Factory::create()
            );
        });
    }
}
