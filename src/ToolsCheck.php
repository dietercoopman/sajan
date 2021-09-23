<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class ToolsCheck extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('tools:check')
            ->setDescription('Check if all tools needed for sajan are present')
            ->setAliases(['tc']);
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
        $this->checkVersion('brew', '--version', $output);
        $this->checkVersion('git', '--version', $output);
        $this->checkVersion('composer', '-V', $output);
        $this->checkVersion('npm', '-v', $output);
        $this->checkVersion('node', '-v', $output);

        return 0;
    }

    private function checkVersion(string $program, string $versioncheck, $output)
    {
        $process = Process::fromShellCommandline($program.' '.$versioncheck);
        if (! $process->run()) {
            $output->writeln('<fg=green>You have "'.trim($process->getOutput()).'" of '.$program.' installed</>');
        } else {
            $output->writeln('<fg=red>'.$program.' is not installed</>');
        }
    }
}
