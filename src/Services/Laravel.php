<?php namespace Dietercoopman\SajanPhp\Services;

use Symfony\Component\Console\Question\ChoiceQuestion;
use function Termwind\{render};

class Laravel extends Server
{
    public function getLaravelApplications($server)
    {

        render('<div class="bg-green-800 m-1 p-1">Retreiving Laravel applications on server \''.$server .'\'</div>');

        $counter = 1;
        collect($this->getLaravels())->each(function ($applicationPath) use (&$applications, &$counter) {
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
                'php'     => $this->getPhpVersion($hostname, $applicationPath),
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
                            <span class='ml-2 w-40'>| $counter </span>
                            <span class='ml-2 w-40'>| Name: {$application['name']}</span>
                            <span class='ml-2 w-40'>| Url: {$application['url']}</span>
                            |<span class='ml-2 pl-2 w-30 font-normal bg-{$laravelColor}-800'>Laravel version: {$application['laravel']}</span>
                            |<span class='ml-2 pl-2 w-30 font-normal bg-{$phpColor}-800'>PHP version: {$application['php']}</span>
                            <span class='ml-2 w-20'>| IP: {$application['ip']}</span>
                            <span class='ml-2 w-60'>| Path: {$application['path']}</span>
                            <span class='ml-2 w-80'>| Config: {$application['config']}</span>
                          </span>");

            render('<hr>');

            $counter++;
        });

    }

    private function checkVersion($applicationPath)
    {
        $command = 'cd ' . $applicationPath . ' && cat composer.lock | grep -A 1 \'"name": "laravel/framework",\'';
        $exec    = $this->connect()->execute(['sudo su', $command]);
        $version = $exec->getOutput();
        return str_replace(['"', ','], '', last(explode(" ", trim(preg_replace('/\s+/', ' ', $version)))));
    }

    private function getPhpVersion($domain, $applicationPath = null)
    {
        // Skip if no domain
        if (empty($domain)) {
            return "unknown";
        }
        
        $phpversion = "unknown";
        
        // Method 1: Try to get from Apache VirtualHost config
        $command = "grep -r '{$domain}' /etc/apache2/sites-available/ /etc/apache2/sites-enabled/ /etc/httpd/conf.d/ 2>/dev/null | head -1 | awk '{print \$1}' | cut -d':' -f1";
        $exec = $this->connect()->execute(['sudo su', $command]);
        $configFile = trim($exec->getOutput());
        
        if (!empty($configFile)) {
            // Read the config file and look for PHP version
            $command = "cat {$configFile} | grep -E 'php|PHP|SetHandler|FilesMatch' | head -5";
            $exec = $this->connect()->execute(['sudo su', $command]);
            $configContent = $exec->getOutput();
            
            // Look for PHP version patterns in config
            // Examples: php8.2-fpm, php82, application/x-httpd-php74, etc.
            if (preg_match('/php[_-]?(\d)\.?(\d)/', $configContent, $matches)) {
                $phpversion = $matches[1] . $matches[2];
            } elseif (preg_match('/php(\d{2})/', $configContent, $matches)) {
                $phpversion = $matches[1];
            }
        }
        
        // Method 2: If still unknown, try running php -v in the application directory
        if ($phpversion === "unknown" && !empty($applicationPath)) {
            $command = "cd {$applicationPath} && php -v 2>/dev/null | head -1";
            $exec = $this->connect()->execute(['sudo su', $command]);
            $output = $exec->getOutput();
            
            // Parse output like "PHP 8.2.10 (cli)..."
            if (preg_match('/PHP (\d)\.(\d)/', $output, $matches)) {
                $phpversion = $matches[1] . $matches[2];
            }
        }

        return $phpversion;
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
