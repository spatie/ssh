<?php

namespace Spatie\Ssh;

use InvalidArgumentException;
use Symfony\Component\Process\Process;

class SshKeyScan
{
    public function getKnownHostFilePath(string $hostAddress, ?string $sshPort, ?string $filePath, string $keyType = 'rsa'): string
    {
        $filePath = $filePath ?? stream_get_meta_data(tmpfile())['uri'];

        $process = new Process([
            $this->getSshKeyscanPath(),
            ...$this->getSshPort($sshPort),
            '-H',
            '-t',
            $keyType,
            $hostAddress,
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new InvalidArgumentException('Could not obtain host keys with ssh-keyscan');
        }

        $result = trim($process->getOutput());

        file_put_contents($filePath, $result);

        return $filePath;
    }

    public function getSshKeyscanPath(): string
    {
        $process = new Process(['which', 'ssh-keyscan']);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new InvalidArgumentException('Could not execute ssh-keyscan on host filesystem');
        }

        return trim($process->getOutput());
    }

    protected function getSshPort(?string $sshPort): array
    {
        return is_null($sshPort)
            ? []
            : ['-p', $sshPort];
    }
}
