<?php namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Dietercoopman\SajanPhp\Services\DatabaseManager;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\Question;
use function Termwind\render;

class MysqlCompare extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('mysql:compare')
            ->setDescription('Compare two mysql databases and get the differences in sql statements')
            ->setAliases(['mc']);
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

        render('<div class="bg-green-800 m-1 p-1">Ok let\'s compare some databases</div>');
        $helper       = $this->getHelper('question');
        $configurator = (new Configurator());
        $choices      = array_keys($configurator->getConfig()['servers']);

        $source = $this->getMysqlServer('source', $input, $output, $configurator, $choices, $helper);
        $target = $this->getMysqlServer('target', $input, $output, $configurator, $choices, $helper);

        $databaseManager = new DatabaseManager($source, $target);
        $sourceDatabases = $databaseManager->getDatabases('source');
        $targetDatabases = $databaseManager->getDatabases('target');

        render('');

        $question = new Question(' Which database do you want as source database? ');
        $question->setAutocompleterValues($sourceDatabases);
        $sourceDatabase = $helper->ask($input, $output, $question);

        $question = new Question(' Which database do you want as target database? ');
        $question->setAutocompleterValues($targetDatabases);
        $targetDatabase = $helper->ask($input, $output, $question);

        render('<div class="ml-1">Ok i\'ll compare ' . $sourceDatabase . ' on ' . $source['host'] . ' with ' . $targetDatabase . ' on ' . $target['host'] . '</div>');
        $html = implode(';<br />', $databaseManager->compare($sourceDatabase, $targetDatabase));
        render('<span class="ml-1 text-sky-400">'.$html.'</span>');

        return 0;
    }

    private function getMysqlServer($type, $input, $output, Configurator $configurator, $choices, $helper): array
    {

        if (count($choices) > 0) {
            $server = $configurator->askFor($helper, $input, $output, $choices, 'Which server do you want to use for you ' . $type . ' database?');
            return $configurator->validateServer($server, 'mysql');
        } else {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
        }

    }
}