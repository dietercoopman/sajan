<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MiscLoveCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('misc:love')
            ->setDescription('Give sajan some love by staring on github')
            ->setAliases(['ml']);
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
        $io = new SymfonyStyle($input, $output);
        $answer = $io->ask('Do you want to star sajan on Github ( this will open a browser ) ? (yes/no)', 'yes');

        if ($answer == 'yes') {
            $output->writeln('<fg=red>Thx for giving sajan some love</> 💕');
            $this->runProcess('open -n https://github.com/dietercoopman/sajan', $output);
        }

        return 0;
    }
}
