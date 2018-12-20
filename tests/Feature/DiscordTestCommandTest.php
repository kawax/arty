<?php

namespace Tests\Feature;

use Tests\TestCase;

use Illuminate\Support\Facades\Notification;
use Illuminate\Notifications\AnonymousNotifiable;

use App\Notifications\TestNotification;

class DiscordTestCommandTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testDiscordTestCommand()
    {
        Notification::fake();

        $this->artisan('discord:test')
             ->assertExitCode(0);

        Notification::assertSentTo(
            new AnonymousNotifiable, TestNotification::class
        );
    }
}
