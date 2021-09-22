<?php namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;


class WebpackBuildCommand extends Command
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
            ->setDescription('Install node modules and run build');
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
            Process::fromShellCommandline('npm install && npm run build')->mustRun()->getOutput();
        } catch (\Exception $e) {
            $output->writeln('<fg=red>Your assets could not build , please check your configuration</>');
        }
        return 0;
    }

}