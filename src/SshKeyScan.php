<?php

namespace Spatie\Ssh;

use InvalidArgumentException;
use Symfony\Component\Process\Process;

/**
 * Obtains SSH key from remote system
 * Assumes:
 *  - Host system is POSIX compliant
 *  - Has ssh-keyscan (part of openssh-client toolchain) installed
 */
class SshKeyScan
{
    public function do(string $hostAddress, ?int $sshPort = 22, ?string $filePath = null, string $keyType = 'rsa'): void
    {
        $process = new Process([
            $this->getSshKeyscanPath(),
            ...$this->getSshPort((string)$sshPort),
            '-t', $keyType,
            $this->getFormattedHostAddress($hostAddress),
        ]);

        $process->run();

        if (!$process->isSuccessful()) {
            var_dump($process);
            throw new InvalidArgumentException('Could not obtain host keys with ssh-keyscan');
        }

//        if ('' === $process->getOutput()) {
//            throw new InvalidArgumentException(sprintf('Could not obtain host key from %s:%s', $hostAddress, $sshPort));
//        }

        (new KnownHosts($filePath))
            ->addHost(
                trim($process->getOutput())
            );
    }

    protected function getSshKeyscanPath(): string
    {
        $process = new Process(['which', 'ssh-keyscan']);

        $process->run();

        if (!$process->isSuccessful()) {
            throw new InvalidArgumentException('Could not execute ssh-keyscan on host filesystem');
        }

        return trim($process->getOutput());
    }

    /**
     * Returns: Hostname,IP address
     * This is to ensure connections to both hostname address and ip address succeed.
     */
    protected function getFormattedHostAddress(string $hostAddress): string
    {
        if (filter_var($hostAddress, FILTER_VALIDATE_IP)) {
            return gethostbyaddr($hostAddress) . ',' . $hostAddress;
        }

        return $hostAddress . ',' . gethostbyname($hostAddress);
    }

    protected function getSshPort(?string $sshPort): array
    {
        return null !== $sshPort
            ? []
            : ['-p', $sshPort];
    }
}
