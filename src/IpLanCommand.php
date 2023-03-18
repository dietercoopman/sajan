<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use function Termwind\render;

class IpLanCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('ip:lan')
            ->setDescription('Get the ip address of your computer in the local network')
            ->setAliases(['il']);
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

        $ip = Process::fromShellCommandline("ifconfig | grep \"inet \" | grep -Fv 127.0.0.1 | awk '{print $2}'")->mustRun()->getOutput();
        render("<span class='ml-1'>Your lan ip address is: <span class='text-red-400'>" . trim($ip) . "</span></span>");
        render('');

        return 0;
    }
}
