<?php

namespace Spatie\Ssh;

use Symfony\Component\Process\Process;

class Ssh
{
    private string $user;

    private string $host;

    private string $pathToPrivateKey = '';

    private ?int $port;

    private bool $enableStrictHostChecking = true;

    public function __construct(string $user, string $host, int $port = null)
    {
        $this->user = $user;

        $this->host = $host;

        $this->port = $port;
    }

    public static function create(...$args): self
    {
        return new static(...$args);
    }

    public function usePrivateKey(string $pathToPrivateKey): self
    {
        $this->pathToPrivateKey = $pathToPrivateKey;

        return $this;
    }

    public function usePort(int $port): self
    {
        $this->port = $port;

        return $this;
    }

    public function enableStrictHostKeyChecking(): self
    {
        $this->enableStrictHostChecking = true;

        return $this;
    }

    public function disableStrictHostKeyChecking(): self
    {
        $this->enableStrictHostChecking = false;

        return $this;
    }

    /**
     * @param string|array $command
     *
     * @return string
     */
    public function getSshCommand($command): string
    {
        $commands = $this->wrapArray($command);

        $extraOptions = $this->getExtraOptions();

        $commandString = implode(PHP_EOL, $commands);

        $delimiter = 'EOF-SPATIE-SSH';

        $target = "{$this->user}@{$this->host}";

        return "ssh {$extraOptions} $target 'bash -se' << \\$delimiter".PHP_EOL
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
        $sshCommand = $this->getSshCommand($command);

        $process = Process::fromShellCommandline($sshCommand);

        $process->setTimeout(0);

        $process->run();

        return $process;
    }

    protected function wrapArray($arrayOrString): array
    {
        return (array) $arrayOrString;
    }

    protected function getExtraOptions(): string
    {
        $extraOptions = [];

        if ($this->pathToPrivateKey) {
            $extraOptions[] = "-i {$this->pathToPrivateKey}";
        }

        if ($this->port >= 0) {
            $extraOptions[] = "-p {$this->port}";
        }

        if (! $this->enableStrictHostChecking) {
            $extraOptions[] = '-o StrictHostKeyChecking=no';
            $extraOptions[] = '-o UserKnownHostsFile=/dev/null';
        }

        return implode(' ', $extraOptions);
    }
}
