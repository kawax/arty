<?php

namespace Tests\Feature;

use Tests\TestCase;

use Revolution\DiscordManager\Facades\Yasmin;

class ServeCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDiscordTestCommand()
    {
        Yasmin::shouldReceive('on')->times(3);
        Yasmin::shouldReceive('login');
        Yasmin::shouldReceive('getLoop->run');

        $this->artisan('discord:serve')
             ->assertExitCode(0);
    }
}
