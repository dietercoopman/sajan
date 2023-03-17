<?php namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;
use function Termwind\{ask, render};


class ServerCreate extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('server:create')
            ->setDescription('Create and save a server')
            ->setAliases(['si']);
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
        $helper = $this->getHelper('question');

        render('<div class="bg-green-800 m-1 p-1">Initialise a new server</div>');
        $name     = ask("<span class='ml-1 mr-1'>What name do you want for the server: </span>");
        $host     = ask("<span class='ml-1 mr-1'>What is the ip/hostname of the server: ");
        $username = ask("<span class='ml-1 mr-1'>What is your username: ");
        $question = new ConfirmationQuestion(' Do you want to connect with an ssh key (y/n) ? ', true, '/^(y|j)/i');

        if ($helper->ask($input, $output, $question)) {
            $possibleKeys = Process::fromShellCommandline('ls ~/.ssh')->mustRun()->getOutput();
            $possibleKeys = collect(explode("\n", $possibleKeys))->filter(function ($key) {
                return strstr($key, '.pub');
            })->transform(function ($key) {
                return str_replace('.pub','',$key);
            })->toArray();

            $question = new ChoiceQuestion(
                ' Please specify which key to use for this server:',
                array_values($possibleKeys),
                0
            );
            $question->setErrorMessage('Server %s is invalid.');
            $keyfile = $helper->ask($input, $output, $question);
        } else {
            $keyfile = null;
        }
        (new Configurator())->store($name, $host, $username, '~/.ssh/'.$keyfile);
        return 0;
    }

}

