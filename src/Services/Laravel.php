<?php namespace Dietercoopman\SajanPhp\Services;

use Symfony\Component\Console\Question\ChoiceQuestion;
use function Termwind\{render};

class Laravel extends Server
{
    public function getLaravelApplications($server)
    {

        render('<div class="bg-green-800 m-1 p-1">Retreiving Laravel applications on server \''.$server .'\'</div>');
        collect($this->getLaravels())->each(function ($applicationPath) use (&$applications) {
            $name     = str_replace('/httpdocs', '', $applicationPath);
            $configs  = $this->getConfig($applicationPath);
            $hostname = $ip = "";
            if ($configs) {
                $hostname = $this->getHostname($configs[0], $applicationPath);
                $ip       = $this->getIp($hostname);
            }

            $application = [
                'name'    => basename($name),
                'path'    => $applicationPath,
                'config'  => json_encode($configs),
                'laravel' => $this->checkVersion($applicationPath),
                'php'     => $this->getPhpVersion($applicationPath),
                'ip'      => $ip,
                'url'     => $hostname
            ];

            $alertText         = 'orange-600';
            $rawLaravelVersion = str_pad(preg_replace('/[^0-9]+/', '', $application['laravel']), 5, 0);
            $laravelColor      = ($rawLaravelVersion < 80000) ? $alertText : 'green';
            if ($laravelColor == $alertText) {
                $laravelColor = ($rawLaravelVersion < 70000) ? 'red' : $alertText;
            }

            $rawPhpVersion = str_pad(preg_replace('/[^0-9]+/', '', $application['php']), 4, 0);
            $phpColor      = ($rawPhpVersion < 8000) ? $alertText : 'green';
            if ($phpColor == $alertText) {
                $phpColor = ($rawPhpVersion < 7000) ? 'red' : $alertText;
            }

            render("<span>
                            <span class='ml-2 w-40'>| Name: {$application['name']}</span>
                            <span class='ml-2 w-40'>| Url: {$application['url']}</span>
                            |<span class='ml-2 pl-2 w-30 font-normal bg-{$laravelColor}-800'>Laravel version: {$application['laravel']}</span>
                            |<span class='ml-2 pl-2 w-30 font-normal bg-{$phpColor}-800'>PHP version: {$application['php']}</span>
                            <span class='ml-2 w-20'>| IP: {$application['ip']}</span>
                            <span class='ml-2 w-60'>| Path: {$application['path']}</span>
                            <span class='ml-2 w-80'>| Config: {$application['config']}</span>
                          </span>");

            render('<hr>');
        });

    }

    private function checkVersion($applicationPath)
    {
        $command = 'cd ' . $applicationPath . ' && cat composer.lock | grep -A 1 \'"name": "laravel/framework",\'';
        $exec    = $this->connect()->execute(['sudo su', $command]);
        $version = $exec->getOutput();
        return str_replace(['"', ','], '', last(explode(" ", trim(preg_replace('/\s+/', ' ', $version)))));
    }

    private function getPhpVersion($applicationPath)
    {
        $command     = 'cd ' . $applicationPath . ' && cat composer.json | grep \'"php":\'';
        $exec        = $this->connect()->execute(['sudo su', $command]);
        $phpversions = $exec->getOutput();
        $phpversions = str_replace(['"php":', '^', ';', '"', ','], '', $phpversions);
        $phpversions = trim(str_replace(["|"], ' or ', $phpversions));

        return !empty($phpversions) ? $phpversions : "unknown";
    }

    private function getLaravels()
    {
        $exec     = $this->connect()->execute(["sudo su", "cd " . $this->rootpath, "locate -b '\.env' '\server.php' | grep '{$this->rootpath}'"]);
        $laravels = explode(" ", trim(preg_replace('/\s+/', ' ', $exec->getOutput())));

        return collect($laravels)->transform(function ($path) {
            return pathinfo($path)['dirname'];
        })->filter(function ($path) {
            return sizeof(explode('/', $path)) <= $this->maxdepth + 1;
        })->unique()->toArray();

    }

}
