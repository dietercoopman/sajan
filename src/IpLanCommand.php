<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Termwind\render;

class IpLanCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('ip:lan')
            ->setDescription('Get the ip address of your computer in the local network')
            ->addOption(
                'wifi-name',
                'w',
                InputOption::VALUE_NONE,
                'Show WiFi network name (slower)'
            )
            ->setAliases(['il']);
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

        try {
            $showWifiName = $input->getOption('wifi-name');
            $interfaces = $this->getAllNetworkInterfaces();
            
            if (empty($interfaces)) {
                render("<span class='ml-1 text-red'>Could not determine LAN IP address.</span>");
                render('');
                return 1;
            }

            // Always show all interfaces
            render("<span class='ml-1'>Network interfaces:</span>");
            foreach ($interfaces as $interface) {
                $label = $this->getInterfaceLabel($interface['name'], !$showWifiName);
                render("<span class='ml-1'>  {$label}: <span class='text-red-400'>{$interface['ip']}</span></span>");
            }
            
            render('');

            return 0;
        } catch (ProcessFailedException $e) {
            render("<span class='ml-1 text-red'>Failed to retrieve LAN IP address.</span>");
            render('');
            return 1;
        }
    }

    /**
     * Get all network interfaces with their IP addresses.
     *
     * @return array<array{name: string, ip: string}>
     * @throws ProcessFailedException
     */
    private function getAllNetworkInterfaces(): array
    {
        $process = Process::fromShellCommandline(
            "ifconfig | grep -E '^[a-z]|inet ' | awk '/^[a-z]/{iface=\$1} /inet /{if(\$2!=\"127.0.0.1\") print iface\" \"\$2}'"
        );
        $process->mustRun();

        $output = trim($process->getOutput());
        if (empty($output)) {
            return [];
        }

        $interfaces = [];
        $lines = explode("\n", $output);
        
        foreach ($lines as $line) {
            if (empty($line)) {
                continue;
            }
            
            $parts = preg_split('/\s+/', $line, 2);
            if (count($parts) === 2) {
                $interfaces[] = [
                    'name' => rtrim($parts[0], ':'),
                    'ip' => $parts[1]
                ];
            }
        }

        // Sort to show common LAN interfaces first (en0, eth0) before VPN (utun, tun)
        usort($interfaces, function($a, $b) {
            $priority = ['en0' => 1, 'en1' => 2, 'eth0' => 1, 'eth1' => 2];
            $aPriority = $priority[$a['name']] ?? 99;
            $bPriority = $priority[$b['name']] ?? 99;
            return $aPriority <=> $bPriority;
        });

        return $interfaces;
    }

    /**
     * Get a human-readable label for the interface.
     *
     * @param string $interfaceName
     * @param bool $skipWifiName
     * @return string
     */
    private function getInterfaceLabel(string $interfaceName, bool $skipWifiName = false): string
    {
        // Check for WiFi and try to get SSID
        if ($interfaceName === 'en0' && !$skipWifiName) {
            $ssid = $this->getWifiSsid($interfaceName);
            if ($ssid) {
                return "WiFi: {$ssid} ({$interfaceName})";
            }
            return "WiFi ({$interfaceName})";
        }

        $labels = [
            'en0' => 'WiFi (en0)',
            'en1' => 'Ethernet (en1)',
            'eth0' => 'Ethernet (eth0)',
            'eth1' => 'Ethernet (eth1)',
        ];

        // Check for VPN interfaces
        if (str_starts_with($interfaceName, 'utun') || 
            str_starts_with($interfaceName, 'tun') || 
            str_starts_with($interfaceName, 'ppp')) {
            return "VPN ({$interfaceName})";
        }

        return $labels[$interfaceName] ?? $interfaceName;
    }

    /**
     * Get the WiFi SSID for a given interface.
     *
     * @param string $interface
     * @return string|null
     */
    private function getWifiSsid(string $interface): ?string
    {
        try {
            // Use system_profiler with a 5 second timeout (it typically takes 4-5 seconds)
            $process = new Process(['system_profiler', 'SPAirPortDataType']);
            $process->setTimeout(5);
            $process->run();
            
            if ($process->isSuccessful()) {
                $output = $process->getOutput();
                
                // Look for "Current Network Information:" followed by the SSID
                if (preg_match('/Current Network Information:\s+([^:]+):/s', $output, $matches)) {
                    return trim($matches[1]);
                }
            }
        } catch (\Exception $e) {
            // Timeout or other error - that's okay, we'll just show the interface name
        }

        return null;
    }
}
