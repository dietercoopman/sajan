<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Termwind\render;

class IpPublicCommand extends BaseCommand
{
    /**
     * List of IP detection services to try (fallback mechanism).
     */
    private const IP_SERVICES = [
        'https://ifconfig.me/',
        'https://api.ipify.org',
        'https://icanhazip.com',
    ];

    /**
     * Timeout for IP detection requests (in seconds).
     */
    private const TIMEOUT = 10;

    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('ip:public')
            ->setDescription('Get the ip address of your computer as exposed to the internet')
            ->setAliases(['ip']);
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

        $ip = $this->fetchPublicIp();

        if ($ip === null) {
            render("<span class='ml-1 text-red'>Failed to retrieve public IP address. Please check your internet connection.</span>");
            render('');
            return 1;
        }

        render("<span class='ml-1'>Your public ip address is: <span class='text-red-400'>" . $ip . "</span></span>");
        render('');

        return 0;
    }

    /**
     * Fetch the public IP address with fallback mechanism.
     *
     * @return string|null The public IP address or null if all services fail
     */
    private function fetchPublicIp(): ?string
    {
        foreach (self::IP_SERVICES as $service) {
            try {
                $ip = $this->tryService($service);
                
                if ($ip !== null && $this->isValidIp($ip)) {
                    return $ip;
                }
            } catch (ProcessFailedException $e) {
                // Try next service
                continue;
            }
        }

        return null;
    }

    /**
     * Try to fetch IP from a specific service.
     *
     * @param string $serviceUrl
     * @return string|null
     * @throws ProcessFailedException
     */
    private function tryService(string $serviceUrl): ?string
    {
        $process = new Process([
            'curl',
            '--silent',
            '--fail',
            '--max-time',
            (string) self::TIMEOUT,
            $serviceUrl
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return trim($process->getOutput());
    }

    /**
     * Validate if the returned value is a valid IP address.
     *
     * @param string $ip
     * @return bool
     */
    private function isValidIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP) !== false;
    }
}
