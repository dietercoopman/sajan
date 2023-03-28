<?php

namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use function Termwind\ask;
use function Termwind\render;

class KeyMakeCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('key:make')
            ->setDescription('Create a new ssh key')
            ->setAliases(['km']);
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
        $passwordsEqual = false;
        $this->title();

        render('<div class="ml-1">Generating public/private rsa key pair.</div>');
        $file = ask('<div class="ml-1 mr-1">Enter file in which to save the key (~/.ssh/id_rsa):</div>');
        while (!$passwordsEqual) {
            $passphrase      = ask('<div class="ml-1 mr-1">Enter passphrase (empty for no passphrase):</div>');
            $passphrasecheck = ask('<div class="ml-1 mr-1">Enter same passphrase again:</div>');
            $passwordsEqual = $passphrasecheck === $passphrase;
        }

        $command = 'ssh-keygen -t rsa -f '.$file.' -q -P "'.$passphrase.'"';
        exec($command);

        render('<div class="ml-1">Your identification has been saved in '.$file .'</div>');
        render('<div class="ml-1">Your public key has been saved in '.$file.'.pub</div>');

        return 0;
    }
}
