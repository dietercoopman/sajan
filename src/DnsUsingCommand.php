<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use function Termwind\render;

class DnsUsingCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('dns:using')
            ->setDescription('Show the dns server your computer is using')
            ->setAliases(['du']);
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

        $output = Process::fromShellCommandline("cat /etc/resolv.conf |grep -i '^nameserver'|head -n1|cut -d ' ' -f2")->mustRun()->getOutput();
        render("<span class='ml-1'>You are using dns with ip: <span class='text-red-400'>" . $output . "</span></span>");
        render('');

        return 0;
    }
}
