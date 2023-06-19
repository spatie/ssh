<?php

use function Spatie\Snapshots\assertMatchesSnapshot;
use Spatie\Ssh\Ssh;

use Symfony\Component\Process\Process;

uses(PHPUnit\Framework\TestCase::class);

beforeEach(function () {
    $this->ssh = (new Ssh('user', 'example.com'));
});

it('can run a single command', function () {
    $command = $this->ssh->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can run multiple commands', function () {
    $command = $this->ssh->getExecuteCommand(['whoami', 'cd /var/log']);

    assertMatchesSnapshot($command);
});

it('can use a specific private key', function () {
    $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can set the port via the constructor', function () {
    $command = (new Ssh('user', 'example.com', 123))->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can set the port via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(123)->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can set the multiplex path via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->useMultiplexing('/home/test/control_masters/%C', '15m')->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can instantiate via the create method')
    ->expect(Ssh::create('user', 'example.com'))
    ->toBeInstanceOf(Ssh::class);

it('can enable strict host checking', function () {
    $command = (new Ssh('user', 'example.com'))->enableStrictHostKeyChecking()->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can enable quiet mode', function () {
    $command = (new Ssh('user', 'example.com'))->enableQuietMode()->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can disable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->disablePasswordAuthentication()->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('it can enable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->enablePasswordAuthentication()->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

test('zero is a valid port number', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(0)->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('throws an exception if a port is negative')
    ->tap(fn () => (new Ssh('user', 'example.com'))->usePort(-45)->getExecuteCommand('whoami'))
    ->throws(Exception::class, 'Port must be a positive integer.');

it('can download a file', function () {
    $command = $this->ssh->getDownloadCommand('spatie.be/current/.env', '.env');

    assertMatchesSnapshot($command);
});

it('can upload a file', function () {
    $command = $this->ssh->getUploadCommand('.env', 'spatie.be/current/.env');

    assertMatchesSnapshot($command);
});

it('can run a command locally', function () {
    $local = new Ssh('user', '127.0.0.1');
    $command = $local->execute('whoami');

    expect(get_current_user())->toEqual(trim($command->getOutput()));
});

it('can configure the used process', function () {
    $command = $this->ssh->configureProcess(function (Process $process) {
        $process->setTimeout(0);
    })->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can handle ipv4 addresses on execute', function () {
    $local = new Ssh('user', '127.0.0.2');
    $command = $local->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can handle ipv4 addresses on upload', function () {
    $local = new Ssh('user', '127.0.0.2');
    $command = $local->getUploadCommand('.env', 'spatie.be/current/.env');

    assertMatchesSnapshot($command);
});

it('can handle ipv6 addresses on execute', function () {
    $local = new Ssh('user', '::1');
    $command = $local->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('can handle ipv6 addresses on upload', function () {
    $local = new Ssh('user', '::1');
    $command = $local->getUploadCommand('.env', 'spatie.be/current/.env');

    assertMatchesSnapshot($command);
});

it('can remove bash command', function () {
    $command = $this->ssh->removeBash()->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('does not alter ssh command when setting timeout', function () {
    $command = $this->ssh->setTimeout(10)->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});

it('does not alter scp command when setting timeout', function () {
    $command = $this->ssh->setTimeout(10)->getUploadCommand('.env', 'spatie.be/current/.env');

    assertMatchesSnapshot($command);
});
