<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;

class LaravelInstallCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('laravel:install')
            ->addArgument('directory', InputArgument::REQUIRED, 'Specify the directory for your new Laravel installation')
            ->setDescription('Install a specific version of Laravel')
            ->setAliases(['li']);
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
        $process = $this->runProcess('git ls-remote --heads https://github.com/laravel/laravel.git | cut -f 2 | cut -b 12-20', $output, null, null, false);
        $versions = $this->parseVersions($process);

        $helper = $this->getHelper('question');
        $question = new ChoiceQuestion(
            '<fg=yellow>Please choose the Laravel version you want to install (defaults to '.$versions[count($versions)].')</>',
            $versions,
            $versions[count($versions)]
        );
        $question->setErrorMessage('Version %s is invalid.');

        $version = $helper->ask($input, $output, $question);
        $directory = $input->getArgument('directory');

        $output->writeln('Installing Laravel '.$version.' into directory "'.$directory.'"');

        $this->runProcess('git clone --branch '.$version.' https://github.com/laravel/laravel.git '.$directory, $output);
        $this->runProcess('cd '.$directory.' && composer install', $output);
        $this->runProcess('cd '.$directory.' && cp .env.example .env && php artisan key:generate', $output);

        return 0;
    }

    /**
     * @param \Symfony\Component\Process\Process $process
     */
    private function parseVersions(\Symfony\Component\Process\Process $process): array
    {
        $versions = array_filter(explode('|', str_replace(['<br />', "\n"], ['|'], nl2br($process->getOutput()))));
        unset($versions[0]);
        unset($versions[count($versions)]);

        return $versions;
    }
}
