<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class StarCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('star')
            ->setDescription('Star the sajan repo on Github');
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

        $io     = new SymfonyStyle($input, $output);
        $answer = $io->ask('Do you want to star sajan on Github ( this will open a browser ) ? (yes/no)', 'yes');

        if ($answer == 'yes') {
            $output->writeln('<fg=red>Thx for giving sajan some love</> 💕');
            $this->runProcess('open -n https://github.com/dietercoopman/sajan', $output);
        }

        return 0;
    }
}
