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
            ->setDescription('Get Laravel applications with their version on a server')
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
        $this->title();

        $configurator = (new Configurator());
        $choices      = array_keys($configurator->getConfig()['servers']);

        if (count($choices) > 0) {
            $helper     = $this->getHelper('question');
            $servername = $configurator->askFor($helper, $input, $output, $choices, 'Please select the server you want to run this command for');
        } else {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
            return 0;
        }

        $config = $configurator->validateServer($servername, 'apache');
        $server = (new Laravel())->init($config);
        $server->getLaravelApplications($servername);

        return 0;
    }

}

