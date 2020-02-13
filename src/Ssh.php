<?php

namespace Spatie\Ssh;

use Symfony\Component\Process\Process;

class Ssh
{
    use SecureConnection;

    /**
     * @param string|array $command
     *
     * @return string
     */
    public function getCommand($command): string
    {
        $commands = $this->wrapArray($command);

        $extraOptions = $this->getExtraOptions();

        $commandString = implode(PHP_EOL, $commands);

        $delimiter = 'EOF-SPATIE-SSH';

        $target = $this->getTarget();

        return "ssh {$extraOptions} {$target} 'bash -se' << \\$delimiter".PHP_EOL
            .$commandString.PHP_EOL
            .$delimiter;
    }

    /**
     * @param string|array $command
     *
     * @return \Symfony\Component\Process\Process
     */
    public function execute($command): Process
    {
        $sshCommand = $this->getCommand($command);

        return $this->run($sshCommand);
    }

    protected function getExtraOptions(): string
    {
        $extraOptions = [];

        if ($this->pathToPrivateKey) {
            $extraOptions[] = "-i {$this->pathToPrivateKey}";
        }

        if (! is_null($this->port)) {
            $extraOptions[] = "-p {$this->port}";
        }

        if (! $this->enableStrictHostChecking) {
            $extraOptions[] = '-o StrictHostKeyChecking=no';
            $extraOptions[] = '-o UserKnownHostsFile=/dev/null';
        }

        return implode(' ', $extraOptions);
    }

    protected function wrapArray($arrayOrString): array
    {
        return (array) $arrayOrString;
    }
}
