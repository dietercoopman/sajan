<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GitCloneCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('git:clone')
            ->addArgument('repo', InputArgument::REQUIRED, 'The repo you want to clone')
            ->setDescription('Clone a git repository to the current directory ( ! not into a new subdirectory )')
            ->setAliases(['gc']);
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
        $this->runProcess('git clone '.$input->getArgument('repo').' .', $output);

        return 0;
    }
}
