<?php

namespace Spatie\Ssh;

use InvalidArgumentException;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * Class SshKeyScan
 * @package Spatie\Ssh
 */
class SshKeyScan
{
    /**
     * @var string
     */
    private string $path;
    /**
     * @var string
     */
    private $result;
    /**
     * @var resource
     */
    private $tmpFile;
    /**
     * @var string
     */
    private string $tmpFilePath;

    /**
     * SshKeyScan constructor.
     * @param string $hostAddress
     * @param string $sshPort
     * @param string $keyType
     * @throws InvalidArgumentException
     */
    public function __construct(string $hostAddress, $sshPort = '22', $keyType = 'rsa')
    {
        if (!$this->systemHasCapability()) {
            throw new InvalidArgumentException('Could not execute ssh-keyscan on host filesystem');
        }

        $keyscan = new Process([$this->path, '-p', (string)$sshPort, '-H', '-t', $keyType, $hostAddress]);
        $keyscan->mustRun();

        if ($keyscan->getExitCode() !== 0) {
            $this->result = trim($keyscan->getOutput());
            $this->writeContentsToTemporaryFile();
        }
    }

    private function writeContentsToTemporaryFile(): void
    {
        $this->tmpFile = tmpfile();
        $this->tmpFilePath = stream_get_meta_data($this->tmpFile)['uri'];
        file_put_contents($this->tmpFilePath, $this->result);
    }

    /**
     * @return string
     */
    public function getResultAsString(): string
    {
        return $this->result;
    }

    /**
     * @return string
     */
    public function getResultAsFilePath(): string
    {
        return $this->tmpFilePath;
    }

    /**
     * @return bool
     */
    public function systemHasCapability(): bool
    {
        $which = new Process(['which', 'ssh-keyscan']);

        try {
            $which->mustRun();
        } catch (ProcessFailedException $exception) {
            return false;
        }

        if ($which->getExitCode() !== 0) {
            return false;
        }

        $this->path = trim($which->getOutput());
        return true;
    }
}
