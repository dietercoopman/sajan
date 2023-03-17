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


class ServerInfo extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('server:info')
            ->setDescription('Get the detailed information of a server')
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
        render('<div class="bg-green-800 m-1 p-1">You want more information of a server?</div>');

        $configurator = (new Configurator());
        $choices      = array_keys($configurator->getConfig()['servers']);

        if (count($choices) > 0) {

            $helper   = $this->getHelper('question');
            $question = new ChoiceQuestion(
                ' Please select the server you want the info from',
                $choices,
                0
            );
            $question->setErrorMessage('Server %s is invalid.');
            $server = $helper->ask($input, $output, $question);
            render('');
            $config = $configurator->getConfig()['servers'][$server];
            foreach ($config as $key => $value) {
                render("<div class='ml-1'>{$key}: {$value}</div>");
            }
            render('');
        } else {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
        }

        return 0;
    }

}

