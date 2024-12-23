<?php

namespace Spatie\Ssh;

use Closure;
use Exception;
use Symfony\Component\Process\Process;

class Ssh
{
    protected ?string $user = null;

    protected string $host;

    protected array $extraOptions = [];

    protected bool $addBash;

    protected Closure $processConfigurationClosure;

    protected Closure $onOutput;

    private int $timeout = 0;

    protected ?string $password = null;

    public function __construct(?string $user, string $host, ?int $port = null, ?string $password = null)
    {
        $this->user = $user;

        $this->host = $host;

        if ($port !== null) {
            $this->usePort($port);
        }

        $this->password = $password;

        $this->addBash = true;

        $this->processConfigurationClosure = fn (Process $process) => null;

        $this->onOutput = fn ($type, $line) => null;
    }

    public static function create(...$args): self
    {
        return new static(...$args);
    }

    public function usePrivateKey(string $pathToPrivateKey): self
    {
        $this->extraOptions['private_key'] = '-i ' . $pathToPrivateKey;

        return $this;
    }

    public function useJumpHost(string $jumpHost): self
    {
        $this->extraOptions['jump_host'] = '-J ' . $jumpHost;

        return $this;
    }

    public function usePort(int $port): self
    {
        if ($port < 0) {
            throw new Exception('Port must be a positive integer.');
        }
        $this->extraOptions['port'] = '-p ' . $port;

        return $this;
    }

    public function usePassword(?string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function useMultiplexing(string $controlPath, string $controlPersist = '10m'): self
    {
        $this->extraOptions['control_master'] = '-o ControlMaster=auto -o ControlPath=' . $controlPath . ' -o ControlPersist=' . $controlPersist;

        return $this;
    }

    public function configureProcess(Closure $processConfigurationClosure): self
    {
        $this->processConfigurationClosure = $processConfigurationClosure;

        return $this;
    }

    public function onOutput(Closure $onOutput): self
    {
        $this->onOutput = $onOutput;

        return $this;
    }

    public function enableStrictHostKeyChecking(): self
    {
        unset($this->extraOptions['enable_strict_check']);

        return $this;
    }

    public function setTimeout(int $timeout): self
    {
        $this->timeout = $timeout;

        return $this;
    }

    public function disableStrictHostKeyChecking(): self
    {
        $this->extraOptions['enable_strict_check'] = '-o StrictHostKeyChecking=no -o UserKnownHostsFile=/dev/null';

        return $this;
    }

    public function enableQuietMode(): self
    {
        $this->extraOptions['quiet'] = '-q';

        return $this;
    }

    public function disableQuietMode(): self
    {
        unset($this->extraOptions['quiet']);

        return $this;
    }

    public function disablePasswordAuthentication(): self
    {
        $this->extraOptions['password_authentication'] = '-o PasswordAuthentication=no';

        return $this;
    }

    public function enablePasswordAuthentication(): self
    {
        unset($this->extraOptions['password_authentication']);

        return $this;
    }

    public function addExtraOption(string $option): self
    {
        $this->extraOptions[] = $option;

        return $this;
    }

    public function removeBash(): self
    {
        $this->addBash = false;

        return $this;
    }

    protected function getPasswordCommand(): string
    {
        if ($this->password !== null) {
            return 'sshpass -p \'' . $this->password . '\' ';
        }

        return '';
    }

    /**
     * @param string|array $command
     *
     * @return string
     */
    public function getExecuteCommand($command): string
    {
        $commands = $this->wrapArray($command);

        $commandString = implode(PHP_EOL, $commands);

        if (in_array($this->host, ['local', 'localhost', '127.0.0.1'])) {
            return $commandString;
        }

        $passwordCommand = $this->getPasswordCommand();
        $extraOptions = implode(' ', $this->getExtraOptions());

        $target = $this->getTargetForSsh();

        $delimiter = 'EOF-SPATIE-SSH';

        $bash = $this->addBash ? "'bash -se'" : '';

        return "{$passwordCommand}ssh {$extraOptions} {$target} {$bash} << \\$delimiter".PHP_EOL
            .$commandString.PHP_EOL
            .$delimiter;
    }

    /**
     * @param string|array $command
     *
     * @return \Symfony\Component\Process\Process
     **/
    public function execute($command): Process
    {
        $sshCommand = $this->getExecuteCommand($command);

        return $this->run($sshCommand);
    }

    /**
     * @param string|array $command
     *
     * @return \Symfony\Component\Process\Process
     */
    public function executeAsync($command): Process
    {
        $sshCommand = $this->getExecuteCommand($command);

        return $this->run($sshCommand, 'start');
    }

    public function getDownloadCommand(string $sourcePath, string $destinationPath): string
    {
        $passwordCommand = $this->getPasswordCommand();

        return "{$passwordCommand}scp {$this->getExtraScpOptions()} {$this->getTargetForScp()}:$sourcePath $destinationPath";
    }

    public function download(string $sourcePath, string $destinationPath): Process
    {
        $downloadCommand = $this->getDownloadCommand($sourcePath, $destinationPath);

        return $this->run($downloadCommand);
    }

    public function getUploadCommand(string $sourcePath, string $destinationPath): string
    {
        $passwordCommand = $this->getPasswordCommand();

        return "{$passwordCommand}scp {$this->getExtraScpOptions()} $sourcePath {$this->getTargetForScp()}:$destinationPath";
    }

    public function upload(string $sourcePath, string $destinationPath): Process
    {
        $uploadCommand = $this->getUploadCommand($sourcePath, $destinationPath);

        return $this->run($uploadCommand);
    }

    protected function getExtraScpOptions(): string
    {
        $extraOptions = $this->extraOptions;

        if (isset($extraOptions['port'])) {
            $extraOptions['port'] = str_replace('-p', '-P', $extraOptions['port']);
        }

        $extraOptions[] = '-r';

        return implode(' ', array_values($extraOptions));
    }

    protected function getExtraOptions(): array
    {
        return array_values($this->extraOptions);
    }

    protected function wrapArray($arrayOrString): array
    {
        return (array) $arrayOrString;
    }

    protected function run(string $command, string $method = 'run'): Process
    {
        $process = Process::fromShellCommandline($command);

        $process->setTimeout($this->timeout);

        ($this->processConfigurationClosure)($process);

        $process->{$method}($this->onOutput);

        return $process;
    }

    protected function getTargetForScp(): string
    {
        $host = filter_var($this->host, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) ? '[' . $this->host . ']' : $this->host;

        if ($this->user === null) {
            return $host;
        }

        return "{$this->user}@{$host}";
    }

    protected function getTargetForSsh(): string
    {
        if ($this->user === null) {
            return $this->host;
        }

        return "{$this->user}@{$this->host}";
    }
}
