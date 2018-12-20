<?php

namespace App\Discord;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use CharlotteDunois\Yasmin\Models\Message;

class DiscordManager
{
    /**
     * @var string
     */
    protected $prefix = '/';

    /**
     * @var array
     */
    protected $commands = [];

    /**
     * @var array
     */
    protected $directs = [];

    /**
     * DiscordManager constructor.
     * @throws \ReflectionException
     */
    public function __construct()
    {
        $this->load(__DIR__ . '/Commands', 'commands');
        $this->load(__DIR__ . '/Directs', 'directs');
    }

    /**
     * @param Message $message
     *
     * @return string
     */
    public function command(Message $message)
    {
        if (!Str::contains($message->content, $this->prefix)) {
            return '';
        }

        $command = Str::before(Str::after($message->content, $this->prefix), ' ');

        if (Arr::has($this->commands, $command)) {
            return $this->commands[$command]($message);
        } else {
            return 'Command Not Found!';
        }
    }

    /**
     * @param Message $message
     *
     * @return string
     */
    public function direct(Message $message)
    {
        if (!Str::contains($message->content, $this->prefix)) {
            return '';
        }

        $command = Str::before(Str::after($message->content, $this->prefix), ' ');

        if (Arr::has($this->directs, $command)) {
            return $this->directs[$command]($message);
        } else {
            return 'Command Not Found!';
        }
    }

    /**
     * @param string|array $paths
     * @param string       $type
     *
     * @throws \ReflectionException
     */
    protected function load($paths, string $type)
    {
        $paths = array_unique(Arr::wrap($paths));

        $paths = array_filter($paths, function ($path) {
            return is_dir($path);
        });

        if (empty($paths)) {
            return;
        }

        $namespace = app()->getNamespace();

        foreach ((new Finder)->in($paths)->files() as $command) {
            $command = $namespace . str_replace(
                    ['/', '.php'],
                    ['\\', ''],
                    Str::after($command->getPathname(), app_path() . DIRECTORY_SEPARATOR)
                );

            if (!(new ReflectionClass($command))->isAbstract()) {
                $com = app($command);

                $this->$type[$com->command] = $com;
            }
        }
    }
}
