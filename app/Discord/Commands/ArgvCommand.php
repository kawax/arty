<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;
use Illuminate\Support\Str;
use Revolution\DiscordManager\Concerns\Input;

class ArgvCommand
{
    use Input;

    /**
     * @var string
     */
    public string $command = 'argv {test} {--text=}';

    /**
     * @param  Message  $message
     * @return void
     */
    public function __invoke(Message $message)
    {
        $argv = explode(' ', Str::after($message->content, config('services.discord.prefix')));

        $input = $this->input($argv);

        $message->reply(sprintf(
            'argv! argument:**%s** option:**%s**',
            $input->getArgument('test'),
            $input->getOption('text')
        ))->done(function (Message $message) {
        });
    }
}
