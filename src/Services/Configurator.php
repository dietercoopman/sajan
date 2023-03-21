<?php namespace Dietercoopman\SajanPhp\Services;

use Dietercoopman\SajanPhp\Traits\HasServer;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Process;
use function Termwind\{ask, render};

class Configurator
{

    use HasServer;


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

        $path = $this->getPath();
        if (file_exists($path) && filesize($path) > 0) {
            return json_decode(file_get_contents($path), true);
        } else {
            return [];
        }
    }

    public function list()
    {
        $counter = 1;
        if (isset($this->getConfig()['servers'])) {
            collect($this->getConfig()['servers'])->each(function ($server) use (&$counter) {
                render("<span class='ml-1'>{$counter}. {$server['name']} ({$server['host']})</span>");
                $counter++;
            });
        }
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
        $file = fopen($this->getPath(), "w") or die("Unable to open file!");
        fwrite($file, json_encode($config));
        fclose($file);
    }

    public function validateServer($servername, $type = "apache")
    {

        $config       = $this->getConfig();
        $serverConfig = $config['servers'][$servername];

        if ($type == "apache") {
            if (!isset($serverConfig['rootpath'])) {
                $serverConfig['rootpath'] = ask("<span class='ml-1 mr-1'>What is the root path of your server ? </span>");
            }
            if (!isset($serverConfig['configPath'])) {
                $serverConfig['configPath'] = ask("<span class='ml-1 mr-1'>What is the config path of your server ? </span>");
            }
        }
        if ($type == "mysql") {
            if (!isset($serverConfig['mysql_port'])) {
                $serverConfig['mysql_port'] = ask("<span class='ml-1 mr-1'>What is the mysql port for your server ? </span>");
            }
            if (!isset($serverConfig['mysql_user'])) {
                $serverConfig['mysql_user'] = ask("<span class='ml-1 mr-1'>What is the mysql user for your server ? </span>");
            }
            if (!isset($serverConfig['mysql_password'])) {
                $serverConfig['mysql_password'] = ask("<span class='ml-1 mr-1'>What is the mysql password for your server ? </span>") ?? "";
            }
            if (!isset($serverConfig['mysql_ssh'])) {
                $question                  = ask(' Do you want to connect to this mysql server over ssh (y/n) ? ', ['y', 'n']);
                $serverConfig['mysql_ssh'] = $question;
            }
        }
        $config['servers'][$servername] = $serverConfig;
        $this->save($config);


        return $config['servers'][$servername];
    }


    public function askFor($helper, $input, $output, $choices, $question)
    {
        $question = new ChoiceQuestion(
            ' ' . $question,
            $choices,
            0
        );
        $question->setErrorMessage('Input %s is invalid.');
        render('');
        return $helper->ask($input, $output, $question);
    }

    private function getPath()
    {
        $homeDir = trim(Process::fromShellCommandline("cd ~ && pwd")->mustRun()->getOutput());
        return $homeDir . "/.sajan";
    }
}
