<?php namespace Dietercoopman\SajanPhp\Services;

use Spatie\Ssh\Ssh;
use function Termwind\{render};

class Wordpress extends Server
{

    public function getWordpressSites()
    {
        $applications = [];
        collect($this->getWordPresses())->each(function ($applicationPath) use (&$applications) {
            $name           = str_replace('/httpdocs', '', $applicationPath);
            $applications[] =
                [
                    'name'          => basename(dirname($name)),
                    'path'          => dirname($applicationPath),
                    //'config'        => $this->getConfig(dirname($applicationPath)),
                    'version'       => $this->checkWPVersion(dirname($applicationPath)),
                    'updatecommand' => $this->getUpdateCommand(dirname($applicationPath)),
                    'ip'            => $this->getIp(basename(dirname($name)))
                ];
        });

        return collect($applications)->sortBy('version')->toArray();
    }

    private function getWordPresses()
    {
        $exec = $this->connect()->execute(["sudo su", "locate -b '\wp-config.php' | grep '{$this->rootpath}'"]);
        return explode(" ", trim(preg_replace('/\s+/', ' ', $exec->getOutput())));
    }

    private function getUpdateCommand($applicationPath)
    {
        $exec = $this->connect()->execute(["sudo su", "cd " . $applicationPath . ' && stat -c %U wp-config.php']);
        $user = str_replace(',', '', trim(preg_replace('/\s+/', ' ', $exec->getOutput())));
        return "cd " . $applicationPath . ' && sudo -u ' . $user . ' wp core update';
    }


    private function checkWPVersion(string $applicationPath)
    {
        $command = 'cd ' . $applicationPath . '/wp-includes && cat version.php | grep \'wp_version =\'';
        $exec    = $this->connect()->execute(['sudo su', $command]);
        $version = $exec->getOutput();
        return str_replace(["'", ';'], '', last(explode(" ", trim(preg_replace('/\s+/', ' ', $version)))));
    }

}
