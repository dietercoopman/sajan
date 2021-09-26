<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Helper\ProgressBar;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class LaravelValetCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('laravel:valet')
            ->setDescription('This will install Laravel valet on your computer')
            ->setAliases(['lv']);
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
        $output->writeln('Installing Laravel valet ... This can take a while ...');
        $this->runProcess('brew update', $output);
        $this->runProcess('brew install php', $output);
        $this->runProcess('composer global require laravel/valet', $output);
        $this->runProcess('valet install', $output);
        return 0;
    }

}
