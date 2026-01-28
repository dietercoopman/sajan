<?php

namespace Dietercoopman\SajanPhp;

use Illuminate\Support\Facades\File;
use Symfony\Component\Console\Output\ConsoleOutput;
use Symfony\Component\Process\Process;

class SajanApplication extends \Symfony\Component\Console\Application
{
    public function __construct(string $name, string $version, $args)
    {
        $output = new ConsoleOutput();
        if (count($args) == 1) {
            $this->brand($output);
        }

        // Check if running update/self-update command
        $isUpdateCommand = isset($args[1]) && in_array($args[1], ['update', 'self-update']);
        
        // Only show outdated message if not running the update command
        if (!$isUpdateCommand) {
            $newVersion = $this->checkOutdated();
            if ($newVersion) {
                $output->writeln('');
                $output->writeln('<bg=red>Your version of sajan is outdated, version <bg=red;options=bold>'.$newVersion.'</> available , please update via the command : sajan self-update</>');
                $output->writeln('');
            }
        }
        
        parent::__construct($name, $version);
    }

    private function brand(ConsoleOutput $output)
    {
        $output->writeln($this->getBrand());
    }

    private function getBrand()
    {

        $brand = '<fg=yellow>             

    █▀▀ █▀▀█ ░░▀ █▀▀█ █▀▀▄ 
    ▀▀█ █▄▄█ ░░█ █▄▄█ █░░█ 
    ▀▀▀ ▀░░▀ █▄█ ▀░░▀ ▀░░▀


</><fg=green>Sajan</> enhances your use of the command line by providing some shortcuts. 
';

        return $brand;
    }

    private function checkOutdated()
    {
        try {
            $connected = @fsockopen('www.google.com', 80);
            if ($connected) {
                fclose($connected);
                
                $process = Process::fromShellCommandline('composer global outdated --direct --format=json');
                $process->run();
                
                if ($process->isSuccessful()) {
                    $data = json_decode($process->getOutput(), true);
                    
                    // Look for sajan in the outdated packages
                    if (isset($data['installed'])) {
                        foreach ($data['installed'] as $package) {
                            if ($package['name'] === 'dietercoopman/sajan') {
                                // Return the latest version available
                                return $package['latest'] ?? $package['latest-status'] ?? null;
                            }
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            return null;
        }
        
        return null;
    }
}
