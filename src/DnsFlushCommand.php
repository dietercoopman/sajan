<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Termwind\render;

class DnsFlushCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('dns:flush')
            ->setDescription('Clear the dns cache of your computer')
            ->setAliases(['df']);
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

        render("<span class='ml-1 text-yellow-400'>Flushing dns needs root privileges , please provide your password ... </span>");
        $process = new Process(['sudo', 'killall', 'HUP', 'mDNSResponder']);
        $process->run();
        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        render("<span class='success'>Dns successfully flushed</span>");
        render('');

        return 0;
    }
}
