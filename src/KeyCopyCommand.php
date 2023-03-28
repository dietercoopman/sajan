<?php

namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use function Termwind\render;

class KeyCopyCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('key:copy')
            ->setDescription('Copy the value of a public key to your clipboard')
            ->setAliases(['kc']);
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
        $helper       = $this->getHelper('question');
        $configurator = (new Configurator());

        $this->title();
        $keyfile = '~/.ssh/' . $configurator->askFor($helper, $input, $output, $this->getPossibleSshKeys(), 'Please select the ssh key you want to use');
        Process::fromShellCommandline('cat '.$keyfile.'.pub | pbcopy')->mustRun()->getOutput();
        render('<span class="success mt-1 mb-1">The public key '.$keyfile.'.pub has been copied to your clipboard.</span>');

        return 0;
    }

    private function getPossibleSshKeys(): array
    {
        $possibleKeys = Process::fromShellCommandline('ls ~/.ssh')->mustRun()->getOutput();
        $possibleKeys = collect(explode("\n", $possibleKeys))->filter(function ($key) {
            return strstr($key, '.pub');
        })->transform(function ($key) {
            return str_replace('.pub', '', $key);
        })->toArray();
        return array_values($possibleKeys);
    }
}
