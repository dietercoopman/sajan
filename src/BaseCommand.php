<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;

class BaseCommand extends Command
{
    /**
     * @param OutputInterface $output
     * @param ProgressBar $progressBar
     * @return Process
     */
    public function runProcess($command, OutputInterface $output, $progressBar = null, $progressvalue = null): Process
    {
        $process = Process::fromShellCommandline($command);
        $process->setTimeout(3600);
        $process->mustRun(function ($type, $buffer) use ($output) {
            $output->write('<fg=green>'.$buffer.'</>');
        });

        if ($progressBar) {
            $progressBar->advance($progressvalue);
        }

        return $process;
    }
}
