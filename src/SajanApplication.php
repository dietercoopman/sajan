<?php

namespace Dietercoopman\SajanPhp;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class SajanApplication extends \Symfony\Component\Console\Application
{
    public function __construct(string $name, string $version, $args)
    {
        $output = new ConsoleOutput();
        if (count($args) == 1) {
            $this->brand($output);
        }

        $newVersion = $this->checkOutdated();
        if ($newVersion) {
            $output->writeln('');
            $output->writeln('<bg=red>Your version of sajan is outdated, version <bg=red;options=bold>'.$newVersion.'</> available , please update via the command : sajan self-update</>');
            $output->writeln('');
        }
        parent::__construct($name, $version);
    }

    private function brand(ConsoleOutput $output)
    {
        $output->writeln($this->getBrand());
    }

    private function getBrand()
    {

        $brand = '<fg=yellow>             

    █▀▀ █▀▀█ ░░▀ █▀▀█ █▀▀▄ 
    ▀▀█ █▄▄█ ░░█ █▄▄█ █░░█ 
    ▀▀▀ ▀░░▀ █▄█ ▀░░▀ ▀░░▀


</><fg=green>Sajan</> enhances your use of the command line by providing some shortcuts. 
';

        return $brand;
    }

    private function checkOutdated()
    {
        try {
            $connected = @fsockopen('www.google.com', 80);
            if ($connected) {
                $outdated = strstr(Process::fromShellCommandline('composer global outdated --direct | grep sajan')->mustRun()->getOutput(), 'dietercoopman/sajan');
                //if sajan is not in the outdated string then it is up to date
                if (strstr($outdated, 'dietercoopman/sajan')) {
                    return true;
                }

            }
        } catch (\Exception $e) {
            return false;
        }
    }
}
