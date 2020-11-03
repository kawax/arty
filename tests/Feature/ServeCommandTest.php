<?php

namespace Tests\Feature;

use Revolution\DiscordManager\Facades\DiscordPHP;
use Tests\TestCase;

class ServeCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDiscordTestCommand()
    {
        DiscordPHP::shouldReceive('on')->times(2);
        DiscordPHP::shouldReceive('run');

        $this->artisan('discord:serve')
             ->assertExitCode(0);
    }
}
