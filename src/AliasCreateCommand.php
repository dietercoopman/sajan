<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Process\Process;

class AliasCreateCommand extends Command
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('alias:create')
            ->setDescription('Create an alias for a program or command');
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
        $question = new Question('<fg=green>Which program/command do you want to alias ?</> ', '');
        $command = $this->getHelper('question')->ask($input, $output, $question);

        $question = new Question('<fg=green>How do you want to name your alias ?</> ', '');
        $aliasname = $this->getHelper('question')->ask($input, $output, $question);

        $commandToRun = 'echo "alias '.$aliasname.'=\"'.$command.'\"" >> ~/.bash_profile';
        Process::fromShellCommandline($commandToRun)->mustRun();

        $this->source();

        return 0;
    }

    private function source()
    {
        $srccommand = 'if [ "$SHELL" == "/bin/zsh" ]; then
    echo source ~/.bash_profile >~/.zshenv
    source ~/.zshenv
    exec zsh -l
  else
    source ~/.bash_profile
    exec bash -l
  fi';
        Process::fromShellCommandline($srccommand)->mustRun();
    }
}
