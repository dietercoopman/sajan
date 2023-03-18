<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;
use function Termwind\render;

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
            ->setDescription('Get the ip address of your computer as exposed to the internet')
            ->setAliases(['ip']);
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

        $ip = Process::fromShellCommandline('curl https://ifconfig.me/')->mustRun()->getOutput();
        render("<span class='ml-1'>Your public ip address is: <span class='text-red-400'>" . trim($ip) . "</span></span>");
        render('');

        return 0;
    }
}
