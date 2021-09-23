<?php

namespace Dietercoopman\SajanPhp;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AliasListCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure()
    {
        $this
            ->setName('alias:list')
            ->setDescription('Get a table overview of all registered aliases on your computer');
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
        $bashprofile = $this->getBashProfileFile();
        $aliases     = $this->parseAliases($bashprofile);
        $this->outputAsTable($output, $aliases);

        return 0;
    }

    private function getBashProfileFile(): string
    {
        $disk = new Filesystem();

        return $disk->get(getenv('HOME') . '/.bash_profile');
    }

    private function parseAliases(string $possibleAliasses): array
    {
        $possibleAliasses = collect(explode("\n", $possibleAliasses));
        $aliases          = $possibleAliasses
            ->filter(function ($line) {
                return $this->isAnAlias($line);
            })
            ->transform(function ($alias) {
                return $this->destructAlias($alias);
            });

        return $aliases->toArray();
    }

    private function destructAlias($aliasString): array
    {
        $aliasDestruct = explode('=', $aliasString);
        $name          = Str::remove('alias ', $aliasDestruct[0]);
        $command       = Str::remove('"', $aliasDestruct[1]);

        return [$name, $command];
    }

    private function isAnAlias($line): bool
    {
        return Str::startsWith($line, 'alias');
    }

    private function outputAsTable(OutputInterface $output, array $aliases)
    {
        $table = new Table($output);

        $table->setHeaders(['Alias', 'Command'])->setRows($aliases);
        $table->render();
    }
}
