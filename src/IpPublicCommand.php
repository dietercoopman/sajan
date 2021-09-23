<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class IpPublicCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('ip:public')
            ->setDescription('Get your public ip address');
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
        $ip = Process::fromShellCommandline('curl https://ifconfig.me/')->mustRun()->getOutput();
        $output->writeln('<fg=yellow>Your public ip address is : </><bg=red> '.$ip.' </>');

        return 0;
    }
}
