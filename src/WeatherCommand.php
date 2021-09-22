<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class WeatherCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('weather')
            ->setDescription('Get the weather in your city');
    }

    /**
     * Execute the command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $question = new Question('<fg=green>You want the weather in  ?</> ', '');
        $location = $this->getHelper('question')->ask($input, $output, $question);
        $location = str_replace(' ', '+', $location);

        $output = Process::fromShellCommandline('curl wttr.in/'.$location)->mustRun()->getOutput();
        echo $output;

        return 0;
    }
}
