<?php namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Dietercoopman\SajanPhp\Services\Laravel;
use Dietercoopman\SajanPhp\Services\Server;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use function Termwind\{render};


class ServerLaravelSitesCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('server:laravelsites')
            ->setDescription('List all laravel sites')
            ->setAliases(['sla']);
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

        render('<div class="bg-green-800 m-1 p-1">Get Laravel applications on a server </div>');

        $configurator = (new Configurator());
        $choices      = array_keys($configurator->getConfig()['servers']);

        if (count($choices) > 0) {
            $helper   = $this->getHelper('question');
            $question = new ChoiceQuestion(
                ' Please select the server you want to run this command for',
                $choices,
                0
            );
            $question->setErrorMessage('Server %s is invalid.');
            $servername = $helper->ask($input, $output, $question);
        } else {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
            return 0;
        }

        $config = $configurator->validateForWebServer($servername);
        $server = (new Laravel())->init($config);
        $server->getLaravelApplications($servername);
        return 0;
    }

}

