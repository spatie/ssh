<?php

namespace Spatie\Ssh;

use Symfony\Component\Process\Process;

class Ssh
{
    private string $user;

    private string $host;

    public function __construct(string $user, string $host)
    {
        $this->user = $user;

        $this->host = $host;
    }

    public function execute(array $commands): Process
    {
        $commandString = implode(PHP_EOL, $commands);

        $delimiter = 'EOF-SPATIE-SSH';

        $target = "{$this->user}@{$this->host}";

        $command = "ssh $target 'bash -se' << \\$delimiter" . PHP_EOL
            . $commandString . PHP_EOL
            . $delimiter;

        $process = Process::fromShellCommandline($command);

        $process->setTimeout(0);

        $process->run();

        return $process;
    }
}
