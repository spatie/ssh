<?php

namespace Spatie\Ssh;

use InvalidArgumentException;
use Symfony\Component\Process\Process;

class SshKeyScan
{
    private string $path;
    private string $result;
    private string $tmpFilePath;
    private ?string $filePath;

    public function __construct(string $hostAddress, ?string $sshPort = '22', ?string $filePath = null, ?string $keyType = 'rsa')
    {
        $this->filePath = $filePath;

        if (! $this->ensureCanRunSshKeyscan()) {
            throw new InvalidArgumentException('Could not execute ssh-keyscan on host filesystem');
        }

        $keyscan = new Process([
            $this->path,
            ...$this->getSshPort($sshPort),
            '-H',
            ...$this->getKeyType($keyType),
            $hostAddress,
        ]);

        $keyscan->run();

        if ($keyscan->isSuccessful()) {
            $this->result = trim($keyscan->getOutput());
            $this->writeContentsToTemporaryFile($filePath);
        } else {
            throw new InvalidArgumentException('Could not obtain host keys with ssh-keyscan');
        }
    }

    public function ensureCanRunSshKeyscan(): bool
    {
        $which = new Process(['which', 'ssh-keyscan']);

        $which->run();

        if ($which->isSuccessful()) {
            $this->path = trim($which->getOutput());

            return true;
        }

        return false;
    }

    protected function getSshPort(?string $sshPort, array $port = []): array
    {
        if (null !== $sshPort) {
            $port = ['-p', $sshPort];
        }

        return $port;
    }

    protected function getKeyType(?string $keyType, array $type = []): array
    {
        if (null !== $keyType) {
            $type = ['-t', $keyType];
        }

        return $type;
    }

    protected function writeContentsToTemporaryFile(?string $customPath): void
    {
        if (null !== $customPath) {
            file_put_contents($customPath, $this->result);
        } else {
            $this->tmpFilePath = stream_get_meta_data(tmpfile())['uri'];
            file_put_contents($this->tmpFilePath, $this->result);
        }
    }

    public function getResultAsFilePath(): string
    {
        return $this->filePath ?? $this->tmpFilePath;
    }
}
