<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GitRevertCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('git:revert')
            ->setDescription('Revert the changes that you made and go back to the files that you had.')
            ->setAliases(['gr']);
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
        $this->runProcess('git add .', $output);
        $this->runProcess('git reset --hard', $output);
        return 0;
    }
}
