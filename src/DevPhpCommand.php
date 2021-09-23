<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class DevPhpCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('dev:php')
            ->addArgument('version', InputArgument::REQUIRED, 'Specify the desired php version')
            ->setDescription('Change the php version on your computer')
            ->setAliases(['dp']);
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
        $version = $input->getArgument('version');

        exec('brew link --overwrite --force php@'.$version);
        exec('brew unlink php && brew link php');
        exec('echo \'export PATH="/usr/local/opt/php@'.$version.'/bin:$PATH"\' >> ~/.zshrc');
        exec('echo \'export PATH="/usr/local/opt/php@'.$version.'/sbin:$PATH"\' >> ~/.zshrc');
        $output->writeln('<fg=green>PHP '.$version.' now active 🔥</> , if the version is not yet active in your console , please restart your terminal');

        $this->source();

        return 0;
    }
}
