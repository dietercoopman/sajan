<?php

namespace Dietercoopman\SajanPhp\Services;

class Health extends Server
{
    /**
     * Get disk space information.
     *
     * @return string
     */
    public function getDiskSpace(): string
    {
        $command = "df -h | grep -E '^/dev/' | awk '{printf \"%-20s %10s %10s %10s %8s\\n\", \$1, \$2, \$3, \$4, \$5}'";
        $exec = $this->connect()->execute(['sudo su', $command]);
        return trim($exec->getOutput());
    }

    /**
     * Get CPU usage statistics.
     *
     * @return array
     */
    public function getCpuUsage(): array
    {
        // Get CPU usage using top
        $command = "top -bn1 | grep 'Cpu(s)' | awk '{print \$2}' | cut -d'%' -f1";
        $exec = $this->connect()->execute(['sudo su', $command]);
        $cpuUsage = trim($exec->getOutput());

        // Get load average
        $command = "uptime | awk -F'load average:' '{print \$2}' | xargs";
        $exec = $this->connect()->execute(['sudo su', $command]);
        $loadAvg = trim($exec->getOutput());

        return [
            'usage' => !empty($cpuUsage) ? round((float)$cpuUsage, 1) : 0,
            'load_avg' => !empty($loadAvg) ? $loadAvg : 'N/A'
        ];
    }

    /**
     * Get memory usage statistics.
     *
     * @return array
     */
    public function getMemoryUsage(): array
    {
        $command = "free -m | awk 'NR==2{printf \"%.0f %.0f %.1f\", \$3, \$2, \$3*100/\$2}'";
        $exec = $this->connect()->execute(['sudo su', $command]);
        $output = trim($exec->getOutput());

        if (!empty($output)) {
            $parts = explode(' ', $output);
            return [
                'used' => $parts[0] . 'MB',
                'total' => $parts[1] . 'MB',
                'percent' => round((float)$parts[2], 1)
            ];
        }

        return [
            'used' => 'N/A',
            'total' => 'N/A',
            'percent' => 0
        ];
    }

    /**
     * Get swap usage statistics.
     *
     * @return array
     */
    public function getSwapUsage(): array
    {
        $command = "free -m | awk 'NR==3{printf \"%.0f %.0f %.1f\", \$3, \$2, (\$2>0?\$3*100/\$2:0)}'";
        $exec = $this->connect()->execute(['sudo su', $command]);
        $output = trim($exec->getOutput());

        if (!empty($output)) {
            $parts = explode(' ', $output);
            return [
                'used' => $parts[0] . 'MB',
                'total' => $parts[1] . 'MB',
                'percent' => round((float)$parts[2], 1)
            ];
        }

        return [
            'used' => '0MB',
            'total' => '0MB',
            'percent' => 0
        ];
    }

    /**
     * Get system uptime.
     *
     * @return string
     */
    public function getUptime(): string
    {
        $command = "uptime -p | sed 's/up //'";
        $exec = $this->connect()->execute(['sudo su', $command]);
        return trim($exec->getOutput());
    }
}
