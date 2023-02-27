<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;

class TestCommand
{
    public string $command = 'test';

    public function __invoke(Message $message): void
    {
        $message->reply('test! '.$message->author->username)
                ->done(function (Message $message) {
                });
    }
}
