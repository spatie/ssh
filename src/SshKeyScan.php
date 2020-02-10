<?php

namespace Spatie\Ssh;

use InvalidArgumentException;
use Symfony\Component\Process\Process;

class SshKeyScan
{
    public static function execute(string $hostAddress, int $sshPort = 22, string $customKnownHostsFileLocation = '', string $keyType = 'rsa'): void
    {
        $process = new Process([
            static::getSshKeyScanPath(),
            ...static::getSshPort((string) $sshPort),
            '-t', $keyType,
            static::getFormattedHostAddress($hostAddress),
        ]);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new InvalidArgumentException('Could not obtain host keys with ssh-keyscan: '.$process->getOutput());
        }

        if ('' !== $process->getOutput()) {
            (new KnownHostsFile($customKnownHostsFileLocation))
                ->addHost(
                    trim($process->getOutput())
                );
        }
    }

    protected static function getSshKeyScanPath(): string
    {
        $process = new Process(['which', 'ssh-keyscan']);

        $process->run();

        if (! $process->isSuccessful()) {
            throw new InvalidArgumentException('Could not execute ssh-keyscan on host filesystem');
        }

        return trim($process->getOutput());
    }

    /**
     * Returns: Hostname,IP address
     * This is to ensure connections to both hostname address and ip address succeed.
     */
    protected static function getFormattedHostAddress(string $hostAddress): string
    {
        if (filter_var($hostAddress, FILTER_VALIDATE_IP)) {
            return gethostbyaddr($hostAddress).','.$hostAddress;
        }

        return $hostAddress.','.gethostbyname($hostAddress);
    }

    protected static function getSshPort(?string $sshPort): array
    {
        return null !== $sshPort
            ? []
            : ['-p', $sshPort];
    }
}
