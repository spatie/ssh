<?php

namespace Spatie\Ssh;

use Symfony\Component\Process\Process;

class Scp
{
    use SecureConnection;

    private bool $recursive = false;

    public function recursive(): Scp
    {
        $this->recursive = true;

        return $this;
    }

    public function download(string $sourcePath, string $destinationPath): Process
    {
        $downloadCommand = $this->getDownloadCommand($sourcePath, $destinationPath);

        return $this->run($downloadCommand);
    }

    public function upload(string $sourcePath, string $destinationPath): Process
    {
        $uploadCommand = $this->getUploadCommand($sourcePath, $destinationPath);

        return $this->run($uploadCommand);
    }

    public function getDownloadCommand(string $sourcePath, string $destinationPath): string
    {
        $extraOptions = $this->getExtraOptions();

        $target = $this->getTarget();

        return "scp {$extraOptions} {$target}:$sourcePath $destinationPath";
    }

    public function getUploadCommand(string $sourcePath, string $destinationPath): string
    {
        $extraOptions = $this->getExtraOptions();

        $target = $this->getTarget();

        return "scp {$extraOptions} $sourcePath {$target}:$destinationPath";
    }

    protected function getExtraOptions(): string
    {
        $extraOptions = [];

        $extraOptions[] = '-r';

        if ($this->pathToPrivateKey) {
            $extraOptions[] = "-i {$this->pathToPrivateKey}";
        }

        if (! is_null($this->port)) {
            $extraOptions[] = "-P {$this->port}";
        }

        if (! $this->enableStrictHostChecking) {
            $extraOptions[] = '-o StrictHostKeyChecking=no';
            $extraOptions[] = '-o UserKnownHostsFile=/dev/null';
        }

        return implode(' ', $extraOptions);
    }
}
