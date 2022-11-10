<?php

namespace Tests\Feature;

use Discord\Discord;
use Mockery\MockInterface;
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
        $this->mock(Discord::class, function (MockInterface $mock) {
            $mock->shouldReceive('on')->times(2);
            $mock->shouldReceive('run');
        });

        $this->artisan('discord:serve')
             ->assertExitCode(0);
    }
}
