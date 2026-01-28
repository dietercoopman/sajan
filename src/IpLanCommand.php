<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Termwind\render;

class IpLanCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
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

        try {
            $ip = $this->getLanIp();
            
            if (empty($ip)) {
                render("<span class='ml-1 text-red'>Could not determine LAN IP address.</span>");
                render('');
                return 1;
            }

            render("<span class='ml-1'>Your lan ip address is: <span class='text-red-400'>{$ip}</span></span>");
            render('');

            return 0;
        } catch (ProcessFailedException $e) {
            render("<span class='ml-1 text-red'>Failed to retrieve LAN IP address.</span>");
            render('');
            return 1;
        }
    }

    /**
     * Get the LAN IP address.
     *
     * @return string
     * @throws ProcessFailedException
     */
    private function getLanIp(): string
    {
        $process = Process::fromShellCommandline(
            "ifconfig | grep \"inet \" | grep -Fv 127.0.0.1 | awk '{print \$2}' | head -n 1"
        );
        $process->mustRun();

        return trim($process->getOutput());
    }
}
