<?php

namespace Dietercoopman\SajanPhp;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class UpdateCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('self-update')
            ->setDescription('Update sajan itself');
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
        $process = Process::fromShellCommandline('composer global update dietercoopman/sajan');
        $process->mustRun(function ($type, $buffer) use ($output) {
            $output->write('<fg=green>'.$buffer.'</>');
        });
        return 0;
    }
}
