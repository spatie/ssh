<?php

namespace Spatie\Ssh;

use Closure;
use Exception;
use Symfony\Component\Process\Process;

class Ssh
{
    protected string $user;

    protected string $host;

    protected string $pathToPrivateKey = '';

    protected ?int $port;

    protected bool $enableStrictHostChecking = true;

    protected Closure $processConfigurationClosure;

    protected Closure $onOutput;

    public function __construct(string $user, string $host, int $port = null)
    {
        $this->user = $user;

        $this->host = $host;

        $this->port = $port;

        $this->processConfigurationClosure = fn(Process $process) => null;

        $this->onOutput = fn($type, $line) => null;
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
        if ($port < 0) {
            throw new Exception('Port must be a positive integer.');
        }
        $this->port = $port;

        return $this;
    }

    public function configureProcess(Closure $processConfigurationClosure): self
    {
        $this->processConfigurationClosure = $processConfigurationClosure;

        return $this;
    }

    public function onOutput(Closure $onOutput): self
    {
        $this->onOutput = $onOutput;

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
    public function getExecuteCommand($command): string
    {
        $commands = $this->wrapArray($command);

        $extraOptions = $this->getExtraSshOptions();

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
        $sshCommand = $this->getExecuteCommand($command);

        return $this->run($sshCommand);
    }

    /**
     * @param string|array $command
     *
     * @return \Symfony\Component\Process\Process
     */
    public function executeAsync($command): Process
    {
        $sshCommand = $this->getExecuteCommand($command);

        return $this->run($sshCommand, 'start');
    }

    public function getDownloadCommand(string $sourcePath, string $destinationPath): string
    {
        return "scp {$this->getExtraScpOptions()} {$this->getTarget()}:$sourcePath $destinationPath";
    }

    public function download(string $sourcePath, string $destinationPath): Process
    {
        $downloadCommand = $this->getDownloadCommand($sourcePath, $destinationPath);

        return $this->run($downloadCommand);
    }

    public function getUploadCommand(string $sourcePath, string $destinationPath): string
    {
        return "scp {$this->getExtraScpOptions()} $sourcePath {$this->getTarget()}:$destinationPath";
    }

    public function upload(string $sourcePath, string $destinationPath): Process
    {
        $uploadCommand = $this->getUploadCommand($sourcePath, $destinationPath);

        return $this->run($uploadCommand);
    }

    protected function getExtraSshOptions(): string
    {
        $extraOptions = $this->getExtraOptions();

        if (! is_null($this->port)) {
            $extraOptions[] = "-p {$this->port}";
        }

        return implode(' ', $extraOptions);
    }

    protected function getExtraScpOptions(): string
    {
        $extraOptions = $this->getExtraOptions();

        $extraOptions[] = '-r';

        if (! is_null($this->port)) {
            $extraOptions[] = "-P {$this->port}";
        }

        return implode(' ', $extraOptions);
    }

    private function getExtraOptions(): array
    {
        $extraOptions = [];

        if ($this->pathToPrivateKey) {
            $extraOptions[] = "-i {$this->pathToPrivateKey}";
        }

        if (! $this->enableStrictHostChecking) {
            $extraOptions[] = '-o StrictHostKeyChecking=no';
            $extraOptions[] = '-o UserKnownHostsFile=/dev/null';
        }

        return $extraOptions;
    }

    protected function wrapArray($arrayOrString): array
    {
        return (array) $arrayOrString;
    }

    protected function run(string $command, string $method = 'run'): Process
    {
        $process = Process::fromShellCommandline($command);

        $process->setTimeout(0);

        ($this->processConfigurationClosure)($process);

        $process->{$method}($this->onOutput);

        return $process;
    }

    protected function getTarget(): string
    {
        return "{$this->user}@{$this->host}";
    }
}
