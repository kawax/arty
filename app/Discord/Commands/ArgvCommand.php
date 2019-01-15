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

        $argv = explode(' ', $message->content);
        array_shift($argv);
        $input = new ArgvInput($argv, $definition);

        return sprintf(
            'argv! argument:**%s** option:**%s**',
            $input->getArgument('test'),
            $input->getOption('text')
        );
    }
}
