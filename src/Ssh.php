<?php

namespace Spatie\Ssh;

use Symfony\Component\Process\Process;

class Ssh
{
    private string $user;

    private string $host;

    private string $pathToPublicKey = '';

    public function __construct(string $user, string $host)
    {
        $this->user = $user;

        $this->host = $host;
    }

    public function usePublicKey($pathToPublicKey): self
    {
        $this->pathToPublicKey = $pathToPublicKey;

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

        $publicKey = $this->pathToPublicKey === ''
            ? ''
            : "-i {$this->pathToPublicKey}";

        $commandString = implode(PHP_EOL, $commands);

        $delimiter = 'EOF-SPATIE-SSH';

        $target = "{$this->user}@{$this->host}";

        $sshCommand = "ssh {$publicKey} $target 'bash -se' << \\$delimiter" . PHP_EOL
            . $commandString . PHP_EOL
            . $delimiter;

        return $sshCommand;
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
        $array = is_array($arrayOrString)
            ? $arrayOrString
            : [$arrayOrString];

        return $array;
    }
}
