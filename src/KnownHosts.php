<?php

namespace Spatie\Ssh;

use RuntimeException;

class KnownHosts
{
    protected string $knownHostsDirectory = '.ssh';

    protected string $knownHostsFile = 'known_hosts';

    protected int $directoryMode = 0700;

    protected int $fileMode = 0644;

    protected string $path;

    protected string $user;

    protected string $file;

    public function __construct(?string $customKnownHostsFile)
    {
        if(! $this->hasPosixExtension()) {
            throw new RuntimeException('PHP does not have POSIX extension enabled');
        }

        if(! $this->hasEnvHomeSet()) {
            throw new RuntimeException('PHP cannot find $HOME env setting');
        }

        $this->user = $this->getUser();
        if (null !== $customKnownHostsFile) {
            $this->path = dirname($customKnownHostsFile);
            $this->file = $customKnownHostsFile;
        } else {
            $this->path = $this->getPath();
            $this->file = $this->getFile();
        }
    }

    public function hasPosixExtension(): bool
    {
        return extension_loaded('posix');
    }

    public function hasEnvHomeSet(): bool
    {
        return null !== getenv('HOME');
    }

    public function addHost(string $hostHash): void
    {
        $fileContents = file($this->file, FILE_SKIP_EMPTY_LINES);
        $fileContents[] = $hostHash.PHP_EOL;
        file_put_contents($this->file, implode(PHP_EOL, array_unique($fileContents)));
    }

    protected function getFile(): string
    {
        return $this->ensureSshKnownHostsFileExists();
    }

    protected function ensureSshDirectoryExists(): void
    {
        if (! is_dir($this->path) && ! mkdir($this->path, $this->directoryMode, true) && ! is_dir($this->path)) {
            throw new RuntimeException('Directory "'.$this->path.'" was not created');
        }
        self::chownIfRequired($this->path, $this->user);
    }

    protected function ensureSshKnownHostsFileExists(): string
    {
        $this->ensureSshDirectoryExists();
        $filePath = $this->path.DIRECTORY_SEPARATOR.$this->knownHostsFile;
        self::touchIfRequired($filePath);
        self::chownIfRequired($filePath, $this->user);
        self::chmodIfRequired($filePath, $this->fileMode);

        return $filePath;
    }

    protected function getUser(): string
    {
        return get_current_user();
    }

    protected function getPath(): string
    {
        return realpath(getenv('HOME').DIRECTORY_SEPARATOR.$this->knownHostsDirectory);
    }

    /**
     * To find out which username belongs to UID, ext-posix is required.
     * https://www.php.net/manual/en/function.posix-getpwuid.php.
     */
    protected static function getUsernameByUid(int $uid): string
    {
        return posix_getpwuid($uid)['name'];
    }

    protected static function chownIfRequired(string $path, string $user): void
    {
        if ($user !== self::getUsernameByUid(fileowner($path))) {
            chown($path, $user);
        }
    }

    protected static function chmodIfRequired(string $path, int $mode): void
    {
        if ($mode !== self::getOctalPermissions($path)) {
            chmod($path, $mode);
        }
    }

    protected static function touchIfRequired(string $path): void
    {
        if (! file_exists($path)) {
            touch($path);
        }
    }

    /**
     * Output of fileperms is not octal, but it can be filtered out:
     * https://www.php.net/manual/en/function.fileperms.php.
     */
    protected static function getOctalPermissions(string $path): int
    {
        return (int) substr(sprintf('%o', fileperms($path)), -4);
    }
}
