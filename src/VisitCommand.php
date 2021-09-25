<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VisitCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('visit')
            ->addArgument('url', InputArgument::REQUIRED, 'The website you want to visit, including https://')
            ->setDescription('Visit a website')
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
        $this->runProcess('open -n '.$input->getArgument('url'), $output);
        return 0;
    }
}
