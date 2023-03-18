<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Process\Process;

class ToolsInstall extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('tools:install')
            ->setDescription('Install the tools used by sajan')
            ->setAliases(['ti']);
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
        $this->title();

        $io = new SymfonyStyle($input, $output);
        $answer = $io->ask('Are you sure you want to install homebrew, node, git and composer? (yes/no)', 'yes');

        if ($answer === 'yes') {
            $this->installHomeBrew();
            $this->installViaHomeBrew('node');
            $this->installViaHomeBrew('git');
            $this->installViaHomeBrew('composer');
        }

        return 0;
    }

    private function installHomeBrew()
    {

        $process = Process::fromShellCommandline('/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"');
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }

    private function installViaHomeBrew(string $program)
    {
        $process = new Process(['brew', 'install', $program]);
        $process->run(function ($type, $buffer) {
            if (Process::ERR === $type) {
                echo 'ERR > '.$buffer;
            } else {
                echo 'OUT > '.$buffer;
            }
        });
    }
}
