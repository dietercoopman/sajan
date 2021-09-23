<?php

namespace Dietercoopman\SajanPhp;

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
        $brand = '
<fg=yellow>          ****     **********           *****             ***          *****          ****         ***
         ****    **************        *******            ****         ******         *****        ****
        ****     ****                 ********            ****        ********        *******      ****
       ****     ****                  **** ****           ****       **** ****        ********     ****
       ****      ****                ****  ****           ****      ****   ****       **** ****    ****
      ****       *************      ****    ****          ****      ****    ****      ****  ****   ****
     ****                 *****     ****    *****         ****     *****    ****      ****   **********
     ****                  ****    ***************        ****    ***************     ****    *********
    ****                   ****   ****        ****       *****    ****       *****    ****      *******
   ****          **************   ****         ****  ********    ****         ****    ****       ******
   ****            *********     ****           ***    ****      ***           ***    ***          ****

</><fg=green>Sajan</> is a lightweight tool to automize some web development tasks
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack
';

        return $brand;
    }

    private function checkOutdated()
    {
        try {
            $version = strstr(Process::fromShellCommandline('composer global outdated --direct | grep sajan')->mustRun()->getOutput(), 'sajan');
            return explode(' ', explode(' ! ', $version)[1])[0];
        } catch (\Exception $e) {
            return false;
        }
    }
}
