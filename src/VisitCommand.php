<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

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
        $output->writeln('<fg=red>Thx for giving sajan some love</> 💕');
        $this->runProcess('open -n https://github.com/dietercoopman/sajan', $output);


        return 0;
    }
}
