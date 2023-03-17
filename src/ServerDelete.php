<?php namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Dietercoopman\SajanPhp\Services\Laravel;
use Dietercoopman\SajanPhp\Services\Server;
use Symfony\Component\Console\Helper\QuestionHelper;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Question\Question;
use function Termwind\{render};


class ServerDelete extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('server:delete')
            ->setDescription('Delete a server')
            ->setAliases(['sd']);
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
        render('<div class="bg-green-800 m-1 p-1">You want to delete a server?</div>');

        $configurator = (new Configurator());
        $choices      = array_keys($configurator->getConfig()['servers']);

        if (count($choices) > 0) {

            $helper   = $this->getHelper('question');
            $question = new ChoiceQuestion(
                ' Please select the server you want to delete',
                $choices,
                0
            );
            $question->setErrorMessage('Server %s is invalid.');

            $server = $helper->ask($input, $output, $question);
            render('');
            $question = new ConfirmationQuestion(' Are you sure you want to delete ' . $server . ' (y/n) ? ', true, '/^(y|j)/i');

            if ($helper->ask($input, $output, $question)) {
                $configurator->deleteServer($server);
            }
        } else {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
        }

        return 0;
    }

}

