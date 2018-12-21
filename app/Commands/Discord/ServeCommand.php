<?php

namespace App\Commands\Discord;

use LaravelZero\Framework\Commands\Command;

use Revolution\DiscordManager\Facades\DiscordManager;

use CharlotteDunois\Yasmin\Client as Yasmin;
use CharlotteDunois\Yasmin\Models\Message;

class ServeCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'discord:serve';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start Discord bot';

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
     * @param Yasmin $client
     *
     * @return mixed
     */
    public function handle(Yasmin $client)
    {
        $client->on('error', function ($error) {
            $this->error($error);
        });

        $client->on('ready', function () use ($client) {
            $this->info('Logged in as ' . $client->user->tag . ' created on ' . $client->user->createdAt->format('d.m.Y H:i:s'));
        });

        $client->on('message', function (Message $message) {
            $this->line('Received Message from ' . $message->author->tag . ' in ' . ($message->channel->type === 'text' ? 'channel #' . $message->channel->name : 'DM') . ' with ' . $message->attachments->count() . ' attachment(s) and ' . \count($message->embeds) . ' embed(s)');

            if ($message->author->bot) {
                return;
            }

            try {
                if ($message->channel->type === 'text') {
                    if ($message->mentions->members->has(config('services.discord.bot'))) {
                        $reply = DiscordManager::command($message);

                        if (filled($reply)) {
                            $message->reply($reply)->done(null, function ($error) {
                                $this->error($error);
                            });
                        }
                    }
                }

                if ($message->channel->type === 'dm') {
                    $reply = DiscordManager::direct($message);

                    if (filled($reply)) {
                        $message->reply($reply)->done(null, function ($error) {
                            $this->error($error);
                        });
                    };
                }
            } catch (\Exception $error) {
                $this->error($error->getMessage());
            }
        });

        $client->login(config('services.discord.token'));
        $client->getLoop()->run();
    }
}
