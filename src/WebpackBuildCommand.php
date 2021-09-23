<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WebpackBuildCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('webpack:build')
            ->setDescription('Install node modules and run build')
            ->setAliases(['wb']);
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
        try {
            $this->runProcess('npm install', $output);
            $this->runProcess('npm run build', $output);
        } catch (\Exception $e) {
            $output->writeln('<fg=red>Your assets could not build , please check your configuration</>');
        }

        return 0;
    }
}
