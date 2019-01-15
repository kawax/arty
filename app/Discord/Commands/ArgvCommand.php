<?php

namespace App\Discord\Commands;

use CharlotteDunois\Yasmin\Models\Message;

use Symfony\Component\Console\Input\ArgvInput;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ArgvCommand
{
    /**
     * @var string
     */
    public $command = 'argv';

    /**
     * @param Message $message
     *
     * @return string
     */
    public function __invoke(Message $message)
    {
        $definition = new InputDefinition([
            new InputArgument('test', InputArgument::OPTIONAL),
            new InputOption('text', 't', InputArgument::OPTIONAL),
        ]);

        $argv = collect(explode(' ', $message->content));
        $argv->shift();

        $input = new ArgvInput($argv->toArray(), $definition);

        return sprintf(
            'argv! argument:**%s** option:**%s**',
            $input->getArgument('test'),
            $input->getOption('text')
        );
    }
}
