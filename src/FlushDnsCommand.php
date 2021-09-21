<?php namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;


class FlushDnsCommand extends Command
{


    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('dnsflush')
            ->setDescription('Clear the dns cache of your computer');
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
        $process = new Process(['sudo', 'killall','HUP','mDNSResponder']);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
        $output->writeln('<fg=green>Dns successfully flushed</>');
        return 0;
    }


}