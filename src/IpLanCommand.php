<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

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
            ->setDescription('Get your lan ip address')
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
        $ip = Process::fromShellCommandline("ifconfig | grep \"inet \" | grep -Fv 127.0.0.1 | awk '{print $2}'")->mustRun()->getOutput();
        $output->writeln('<fg=yellow>Your lan ip address is : </><bg=red> '.trim($ip).' </>');

        return 0;
    }
}
