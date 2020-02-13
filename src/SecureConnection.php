<?php

namespace Spatie\Ssh;

use Exception;
use Symfony\Component\Process\Process;

trait SecureConnection
{
    protected string $user;

    protected string $host;

    protected string $pathToPrivateKey = '';

    protected ?int $port;

    protected bool $enableStrictHostChecking = true;

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
        if ($port < 0) {
            throw new Exception('Port must be a positive integer.');
        }
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

    public function run(string $command): Process
    {
        $process = Process::fromShellCommandline($command);

        $process->setTimeout(0);

        $process->run();

        return $process;
    }

    protected function getTarget(): string
    {
        return "{$this->user}@{$this->host}";
    }
}
