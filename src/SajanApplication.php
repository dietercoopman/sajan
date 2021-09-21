<?php namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Output\ConsoleOutput;

class SajanApplication extends \Symfony\Component\Console\Application
{

    public function __construct(string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
//        $this->brand();
        parent::__construct($name, $version);
    }

    private function brand()
    {
        $output = new ConsoleOutput();
        $output->writeln(file_get_contents('src/brand.txt'));
    }
}