<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class ToolsUpdate extends Command
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('tools:update')
            ->setDescription('Update tools used by sajan');
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
        $io = new SymfonyStyle($input, $output);
        $answer = $io->ask('Are you sure you want to update all tools? (yes/no)', 'yes');

        if ($answer === 'yes') {
            $this->updateViaHomeBrew($output);
        }

        return 0;
    }

    private function updateViaHomeBrew($output)
    {
        $process = Process::fromShellCommandline('brew update && brew upgrade');
        $process->mustRun();
        $output->writeln('<fg=green>'.$process->getOutput().'</>');
    }
}