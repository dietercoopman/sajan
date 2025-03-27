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
                'php'     => $this->getPhpVersion($hostname),
                'ip'      => $ip,
                'url'     => $hostname
            ];

            $alertText         = 'orange-600';

            $rawLaravelVersion = preg_replace('/[^0-9.]+/', '', $application['laravel']);
            //get the part of the version number before the first dot
            $rawLaravelVersion = explode('.', $rawLaravelVersion)[0];

            $laravelColor      = ($rawLaravelVersion < 11) ? $alertText : 'green';
            if ($laravelColor == $alertText) {
                $laravelColor = ($rawLaravelVersion < 9) ? 'red' : $alertText;
            }

            $rawPhpVersion = $application['php'];
            $phpColor      = ($rawPhpVersion < 80) ? $alertText : 'green';
            if ($phpColor == $alertText) {
                $phpColor = ($rawPhpVersion < 70) ? 'red' : $alertText;
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

    private function getPhpVersion($domain)
    {
        //get the php version

        $command     = "plesk db \"SELECT dom.name, hosting.php_handler_id FROM domains dom JOIN hosting ON dom.id=hosting.dom_id WHERE dom.name='".$domain."' and php_handler_id like '%php%'\"";
        $exec        = $this->connect()->execute(['sudo su', $command]);
        $output = $exec->getOutput();
        $phpversions = "unknown";
        // Ensure output is valid
        if ($output) {
            // Extract the relevant line (last row before the table border)
            $lines = explode("\n", trim($output));

            if (count($lines) >= 3) {
                $data_row = trim($lines[3]); // The third line contains the actual data

                // Split by '|' and extract PHP handler column
                $columns = array_map('trim', explode('|', $data_row));

                $phpversions = $columns[2];
            }
        }

// Use regular expression to extract the numbers after 'php'
        $phpversions = preg_replace('/\D/', '', $phpversions);


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
