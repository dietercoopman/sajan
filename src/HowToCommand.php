<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class HowToCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('howto:history')
            ->setDescription('How to get items for your history')
            ->setAliases(['hh']);
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
        $output->writeln('');
        $output->writeln('<fg=yellow>If you want to find items in your console history you can simply run <fg=green>history | grep \'yourterm\'</>. This will give you all history items for the term you typed.</>');
        $output->writeln('');
        return 0;
    }
}
