<?php namespace Dietercoopman\SajanPhp\Services;

use function Termwind\{ask, render};

class Configurator
{
    private $path = '/Users/dieter/.sajan';


    public function store($name, $host, $username, $keyfile)
    {
        $server                   = get_defined_vars();
        $config                   = $this->getConfig();
        $config['servers'][$name] = $server;

        $this->save($config);

        render("<span class='m-1'>Server with name {$name} is saved!</span>");

    }

    public function getConfig()
    {
        if (file_exists($this->path) && filesize($this->path) > 0) {
            return json_decode(file_get_contents($this->path), true);
        } else {
            return [];
        }
    }

    public function list()
    {
        $counter = 1;
        collect($this->getConfig()['servers'])->each(function ($server) use (&$counter) {
            render("<span class='ml-1'>{$counter}. {$server['name']} ({$server['host']})</span>");
            $counter++;
        });
        if ($counter == 1) {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
        }
        render('');

    }

    public function deleteServer($server)
    {
        $config = $this->getConfig();
        unset($config['servers'][$server]);
        $this->save($config);
        render("<span class='ml-1 mt-1'>{$server} is deleted!</span>");
        render('');
    }

    private function save($config)
    {
        $file = fopen($this->path, "w") or die("Unable to open file!");
        fwrite($file, json_encode($config));
        fclose($file);
    }

    public function validateForWebServer($servername)
    {

        $config       = $this->getConfig();
        $serverConfig = $config['servers'][$servername];
        if (!isset($serverConfig['rootpath'])) {
            $serverConfig['rootpath'] = ask("<span class='ml-1 mr-1'>What is the root path of your webserver ? </span>");
        }
        if (!isset($serverConfig['configPath'])) {
            $serverConfig['configPath'] = ask("<span class='ml-1 mr-1'>What is the config path of your webserver ? </span>");
        }
        $config['servers'][$servername] = $serverConfig;
        $this->save($config);


        return $config['servers'][$servername];
    }
}
