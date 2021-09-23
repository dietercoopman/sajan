<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class DevOpenCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('dev:open')
            ->setDescription('Open phpstorm, finder and gittower for this folder');
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
        $process = new Process(['pstorm', '.']);
        $process->run();

        $process = new Process(['gittower', '.']);
        $process->run();

        $process = new Process(['open', '.']);
        $process->run();

        $output->writeln('<fg=green>Happy coding</>');

        return 0;
    }
}
