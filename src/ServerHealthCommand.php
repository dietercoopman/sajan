<?php

namespace Dietercoopman\SajanPhp;

use Dietercoopman\SajanPhp\Services\Configurator;
use Dietercoopman\SajanPhp\Services\Health;
use Dietercoopman\SajanPhp\Traits\HasServer;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use function Termwind\render;

class ServerHealthCommand extends BaseCommand
{
    use HasServer;

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('server:health')
            ->setDescription('Monitor server health with live CPU, memory and disk usage')
            ->addOption(
                'interval',
                'i',
                InputOption::VALUE_OPTIONAL,
                'Refresh interval in seconds',
                1
            )
            ->setAliases(['sh']);
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

        $configurator = new Configurator();
        $choices = $this->getServers($configurator);

        if (count($choices) === 0) {
            render('<div class="m-1">You have no saved servers, you can create one with the \'server:create\' command.</div>');
            return 1;
        }

        $helper = $this->getHelper('question');
        $serverName = $configurator->askFor($helper, $input, $output, $choices, 'Which server do you want to monitor?');
        
        $config = $configurator->validateServer($serverName);
        $health = (new Health())->init($config);

        $interval = (int) $input->getOption('interval');
        
        render('');
        render("<div class='ml-1 text-green'>Monitoring server: <span class='font-bold'>{$serverName}</span></div>");
        render("<div class='ml-1 text-yellow'>Press Ctrl+C to stop monitoring</div>");
        render('');

        // Initial disk space check (static)
        $this->showDiskSpace($health);
        render('');
        
        // Print static labels once
        render("<div class='ml-1 text-white font-bold'>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</div>");
        render("<div class='ml-1 text-white font-bold'>LIVE MONITORING (refreshes every second)</div>");
        render("<div class='ml-1 text-white font-bold'>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</div>");

        // Live monitoring loop
        $iteration = 0;
        while (true) {
            $this->updateLiveStats($health, $iteration);
            sleep($interval);
            $iteration++;
        }

        return 0;
    }

    /**
     * Show disk space information.
     *
     * @param Health $health
     * @return void
     */
    private function showDiskSpace(Health $health): void
    {
        render("<div class='ml-1 text-white font-bold'>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</div>");
        render("<div class='ml-1 text-white font-bold'>DISK SPACE</div>");
        render("<div class='ml-1 text-white font-bold'>━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━</div>");

        $diskOutput = $health->getDiskSpace();

        if (!empty($diskOutput)) {
            $lines = explode("\n", $diskOutput);
            
            render("<div class='ml-1 mt-1'> </div>");
            
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                
                // Parse the line
                $parts = preg_split('/\s+/', trim($line));
                if (count($parts) < 5) continue;
                
                $device = $parts[0];
                $size = $parts[1];
                $used = $parts[2];
                $free = $parts[3];
                $usePercent = $parts[4];
                
                // Shorten device name if too long
                if (strlen($device) > 30) {
                    $device = substr($device, 0, 27) . '...';
                }
                
                // Color code based on usage percentage
                $usage = (int) str_replace('%', '', $usePercent);
                if ($usage >= 90) {
                    $color = 'text-red';
                    $bgColor = 'bg-red-900';
                } elseif ($usage >= 75) {
                    $color = 'text-yellow';
                    $bgColor = 'bg-yellow-900';
                } else {
                    $color = 'text-green';
                    $bgColor = 'bg-green-900';
                }
                
                // Create a visual progress bar (smaller)
                $barWidth = 20;
                $filledBars = round(($usage / 100) * $barWidth);
                $emptyBars = $barWidth - $filledBars;
                $bar = str_repeat('█', $filledBars) . str_repeat('░', $emptyBars);
                
                // Compact format - everything on 2 lines
                render("<div class='ml-2'><span class='text-white font-bold'>•</span> <span class='text-cyan'>{$device}</span> <span class='text-gray'>({$size} total)</span></div>");
                render("<div class='ml-4'><span class='{$color}'>[{$bar}]</span> <span class='{$bgColor} px-1'>{$usePercent}</span> <span class='text-gray ml-2'>{$used} used, {$free} free</span></div>");
            }
        }
    }

    /**
     * Update live CPU and memory statistics (values only).
     *
     * @param Health $health
     * @param int $iteration
     * @return void
     */
    private function updateLiveStats(Health $health, int $iteration): void
    {
        // Get CPU usage
        $cpuStats = $health->getCpuUsage();
        
        // Get memory usage
        $memoryStats = $health->getMemoryUsage();

        if ($iteration > 0) {
            // Move cursor up 4 lines to overwrite previous values
            echo "\033[4A";
        }

        // Display CPU (only the values, labels are already printed)
        $cpuColor = $this->getUsageColor($cpuStats['usage']);
        render("<div class='ml-1'><span class='font-bold'>CPU Usage:</span> <span class='{$cpuColor}'>{$cpuStats['usage']}%</span> {$this->getBar($cpuStats['usage'])}</div>");
        render("<div class='ml-1 text-gray'>Load Average: {$cpuStats['load_avg']}</div>");

        // Display Memory
        $memColor = $this->getUsageColor($memoryStats['percent']);
        render("<div class='ml-1'><span class='font-bold'>Memory:</span> <span class='{$memColor}'>{$memoryStats['percent']}%</span> {$this->getBar($memoryStats['percent'])} ({$memoryStats['used']} / {$memoryStats['total']})</div>");
        
        render("<div class='ml-1 text-gray'>Last updated: " . date('H:i:s') . "</div>");
    }

    /**
     * Get color based on usage percentage.
     *
     * @param float $usage
     * @return string
     */
    private function getUsageColor(float $usage): string
    {
        if ($usage >= 90) {
            return 'text-red';
        } elseif ($usage >= 75) {
            return 'text-yellow';
        } else {
            return 'text-green';
        }
    }

    /**
     * Generate a visual bar for usage percentage.
     *
     * @param float $percent
     * @return string
     */
    private function getBar(float $percent): string
    {
        $barLength = 20;
        $filled = round(($percent / 100) * $barLength);
        $empty = $barLength - $filled;

        $color = $this->getUsageColor($percent);
        
        return '<span class="' . $color . '">[' . str_repeat('█', $filled) . str_repeat('░', $empty) . ']</span>';
    }
}
