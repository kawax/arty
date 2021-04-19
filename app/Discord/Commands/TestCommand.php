<?php

namespace App\Discord\Commands;

use Discord\Parts\Channel\Message;

class TestCommand
{
    /**
     * @var string
     */
    public $command = 'test';

    /**
     * @param  Message  $message
     *
     * @return void
     */
    public function __invoke(Message $message)
    {
        $message->reply('test! '.$message->author->username)
                ->done(function (Message $message) {
                });
    }
}
