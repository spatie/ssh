<?php

namespace Spatie\Ssh;

class KnownHostsFile
{
    protected string $path;

    public function __construct(string $path)
    {
        $this->path = $path === ''
            ? getenv('HOME') . '/.ssh/known_hosts'
            : $path;
    }

    public function addHost(string $hostHash): void
    {
        $fileContents = file($this->path, FILE_SKIP_EMPTY_LINES);

        $fileContents[] = $hostHash.PHP_EOL;

        file_put_contents($this->path, implode(PHP_EOL, array_unique($fileContents)));
    }
}
