<?php

namespace App\Discord\Directs;

use Discord\Parts\Channel\Message;

class DmTestCommand
{
    public string $command = 'test';

    public function __invoke(Message $message): void
    {
        $message->reply('dm test! '.$message->author->username)
                ->done(function (Message $message) {
                });
    }
}
