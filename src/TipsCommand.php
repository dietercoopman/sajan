<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class TipsCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('tips')
            ->setDescription('Get some tips to better use your commandline');
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
        $this->title();

        $io = new SymfonyStyle($input, $output);
        $io->title('Aliases');
        $io->writeln('Show all available aliases:  <fg=green>alias</>');
        $io->writeln('Create an alias:  <fg=green>alias your-alias-name=your-command-to-alias</>');

        $io->title('Git');
        $io->writeln('Show your remote git repo: <fg=green>git remote -v</>');
        $io->writeln('Reset branch to last commit: <fg=green>git add . && git reset --hard</>');

        $io->title('Start programs from command line');
        $io->writeln('Open phpstorm:  <fg=green>pstorm .</>');
        $io->writeln('Open finder:  <fg=green>open .</>');
        $io->writeln('Open tower:  <fg=green>gittower .</>');
        $io->writeln('Open vscode:  <fg=green>code .</>');

        $io->title('Commands history');
        $io->writeln('Search your history: <fg=green>history | grep $term</>');

        $io->title('Ssh keys');
        $io->writeln('Create an ssh key:  <fg=green>ssh-keygen -t rsa</>');
        $io->writeln('Copy an ssh key to the clipboard:  <fg=green>pbcopy <  ~/.ssh/key-to-copy</>');

        $io->writeln('');




        return 0;
    }
}
