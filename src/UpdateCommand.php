<?php

namespace Dietercoopman\SajanPhp;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;
use function Termwind\render;

class UpdateCommand extends BaseCommand
{
    /**
     * Configure the command.
     *
     * @return void
     */
    protected function configure(): void
    {
        $this
            ->setName('self-update')
            ->setDescription('Update sajan itself')
            ->setAliases(['update']);
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

        // Check if composer is available
        if (!$this->isComposerAvailable()) {
            render("<span class='ml-1 text-red'>Error: Composer is not installed or not in PATH.</span>");
            render('');
            return 1;
        }

        // Get current version
        $currentVersion = $this->getCurrentVersion();

        // Check if update is available
        render("<span class='ml-1'>Checking for updates...</span>");
        render('');
        
        $latestVersion = $this->getLatestVersion();
        
        if ($latestVersion && $currentVersion === $latestVersion) {
            render("<span class='ml-1 text-green'>✓ You are already on the latest version ({$currentVersion}).</span>");
            render('');
            return 0;
        }

        if ($latestVersion && $currentVersion) {
            render("<span class='ml-1'>Latest version available: <span class='text-green'>{$latestVersion}</span></span>");
            render('');
        }

        // Ask for confirmation unless --no-interaction is specified
        if ($input->isInteractive()) {
            $helper = $this->getHelper('question');
            $question = new ConfirmationQuestion(
                '<fg=yellow>Are you sure you want to update sajan? (yes/no) [yes]:</> ',
                true
            );

            if (!$helper->ask($input, $output, $question)) {
                render("<span class='ml-1 text-yellow'>Update cancelled.</span>");
                render('');
                return 0;
            }
        }

        render("<span class='ml-1'>Updating sajan...</span>");
        render('');

        try {
            // Run the update command
            $this->runProcess('composer global update dietercoopman/sajan', $output);

            render('');
            render("<span class='ml-1 text-green'>✓ Sajan has been successfully updated!</span>");
            
            // Get new version
            $newVersion = $this->getCurrentVersion();
            if ($newVersion && $newVersion !== $currentVersion) {
                render("<span class='ml-1'>New version: <span class='text-green'>{$newVersion}</span></span>");
            }
            render('');

            return 0;
        } catch (ProcessFailedException $e) {
            render('');
            render("<span class='ml-1 text-red'>✗ Update failed: {$e->getMessage()}</span>");
            render('');
            return 1;
        }
    }

    /**
     * Check if composer is available in the system.
     *
     * @return bool
     */
    private function isComposerAvailable(): bool
    {
        $process = new Process(['which', 'composer']);
        $process->run();

        return $process->isSuccessful();
    }

    /**
     * Get the current installed version of sajan.
     *
     * @return string|null
     */
    private function getCurrentVersion(): ?string
    {
        try {
            $process = new Process(['composer', 'global', 'show', 'dietercoopman/sajan', '--format=json']);
            $process->run();

            if ($process->isSuccessful()) {
                $data = json_decode($process->getOutput(), true);
                return $data['versions'][0] ?? null;
            }
        } catch (\Exception $e) {
            // If we can't get the version, that's okay
        }

        return null;
    }

    /**
     * Get the latest available version of sajan from Packagist.
     *
     * @return string|null
     */
    private function getLatestVersion(): ?string
    {
        try {
            $process = new Process(['composer', 'global', 'show', 'dietercoopman/sajan', '--latest', '--format=json']);
            $process->run();

            if ($process->isSuccessful()) {
                $data = json_decode($process->getOutput(), true);
                return $data['latest'] ?? null;
            }
        } catch (\Exception $e) {
            // If we can't get the latest version, that's okay
        }

        return null;
    }
}
