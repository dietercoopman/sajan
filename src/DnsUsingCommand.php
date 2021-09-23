<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
            ->setDescription('Show the dns server your computer is using');
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
        $output->write('<fg=yellow>You are using dns with ip : </>');
        $this->runProcess("cat /etc/resolv.conf |grep -i '^nameserver'|head -n1|cut -d ' ' -f2", $output);
        return 0;
    }
}
