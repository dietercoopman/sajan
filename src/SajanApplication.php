<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Output\ConsoleOutput;

class SajanApplication extends \Symfony\Component\Console\Application
{
    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        $this->brand();
        parent::__construct($name, $version);
    }

    private function brand()
    {
        $output = new ConsoleOutput();
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
This tool provides you with some automation tasks for Laravel, Git, PhpStorm and Webpack';
        return $brand;
    }
}
