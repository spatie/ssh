<?php

<<<<<<< HEAD
use function Spatie\Snapshots\assertMatchesSnapshot;
||||||| parent of e7a6919 (refactor: SshTest)
namespace Spatie\Ssh\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
=======
>>>>>>> e7a6919 (refactor: SshTest)
use Spatie\Ssh\Ssh;

use Symfony\Component\Process\Process;

<<<<<<< HEAD
uses(PHPUnit\Framework\TestCase::class);
||||||| parent of e7a6919 (refactor: SshTest)
class SshTest extends TestCase
{
    use MatchesSnapshots;
=======
use function Spatie\Snapshots\assertMatchesSnapshot;
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
beforeEach(function () {
    $this->ssh = (new Ssh('user', 'example.com'));
});
||||||| parent of e7a6919 (refactor: SshTest)
    private Ssh $ssh;
=======
uses(PHPUnit\Framework\TestCase::class);
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can run a single command', function () {
    $command = $this->ssh->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    public function setUp(): void
    {
        parent::setUp();
=======
beforeEach(function () {
    $this->ssh = (new Ssh('user', 'example.com'));
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->ssh = (new Ssh('user', 'example.com'));
    }
=======
it('can run a single command', function () {
    $command = $this->ssh->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can run multiple commands', function () {
    $command = $this->ssh->getExecuteCommand(['whoami', 'cd /var/log']);
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_run_a_single_command()
    {
        $command = $this->ssh->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can run multiple commands', function () {
    $command = $this->ssh->getExecuteCommand(['whoami', 'cd /var/log']);
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can use a specific private key', function () {
    $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_run_multiple_commands()
    {
        $command = $this->ssh->getExecuteCommand(['whoami', 'cd /var/log']);
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can use a specific private key', function () {
    $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can set the port via the constructor', function () {
    $command = (new Ssh('user', 'example.com', 123))->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_use_a_specific_private_key()
    {
        $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can set the port via the constructor', function () {
    $command = (new Ssh('user', 'example.com', 123))->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can set the port via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(123)->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_set_the_port_via_the_constructor()
    {
        $command = (new Ssh('user', 'example.com', 123))->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can set the port via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(123)->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can set the multiplex path via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->useMultiplexing('/home/test/control_masters/%C', '15m')->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_set_the_port_via_the_dedicated_function()
    {
        $command = (new Ssh('user', 'example.com'))->usePort(123)->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can set the multiplex path via the dedicated function', function () {
    $command = (new Ssh('user', 'example.com'))->useMultiplexing('/home/test/control_masters/%C', '15m')->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can instantiate via the create method')
    ->expect(Ssh::create('user', 'example.com'))
    ->toBeInstanceOf(Ssh::class);
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_set_the_multiplex_path_via_the_dedicated_function()
    {
        $command = (new Ssh('user', 'example.com'))->useMultiplexing('/home/test/control_masters/%C', '15m')->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can enable strict host checking', function () {
    $command = (new Ssh('user', 'example.com'))->enableStrictHostKeyChecking()->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can instantiate via the create method')
    ->expect(Ssh::create('user', 'example.com'))
    ->toBeInstanceOf(Ssh::class);
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_instantiate_via_the_create_method()
    {
        $this->assertInstanceOf(Ssh::class, Ssh::create('user', 'example.com'));
    }
=======
it('can enable strict host checking', function () {
    $command = (new Ssh('user', 'example.com'))->enableStrictHostKeyChecking()->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can enable quiet mode', function () {
    $command = (new Ssh('user', 'example.com'))->enableQuietMode()->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_enable_strict_host_checking()
    {
        $command = (new Ssh('user', 'example.com'))->enableStrictHostKeyChecking()->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can enable quiet mode', function () {
    $command = (new Ssh('user', 'example.com'))->enableQuietMode()->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can disable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->disablePasswordAuthentication()->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_enable_quiet_mode()
    {
        $command = (new Ssh('user', 'example.com'))->enableQuietMode()->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('can disable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->disablePasswordAuthentication()->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('it can enable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->enablePasswordAuthentication()->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_disable_password_authentication()
    {
        $command = (new Ssh('user', 'example.com'))->disablePasswordAuthentication()->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('it can enable password authentication', function () {
    $command = (new Ssh('user', 'example.com'))->enablePasswordAuthentication()->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
test('zero is a valid port number', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(0)->getExecuteCommand('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_enable_password_authentication()
    {
        $command = (new Ssh('user', 'example.com'))->enablePasswordAuthentication()->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
test('zero is a valid port number', function () {
    $command = (new Ssh('user', 'example.com'))->usePort(0)->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('throws an exception if a port is negative')
    ->tap(fn () => (new Ssh('user', 'example.com'))->usePort(-45)->getExecuteCommand('whoami'))
    ->throws(Exception::class, 'Port must be a positive integer.');
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function zero_is_a_valid_port_number()
    {
        $command = (new Ssh('user', 'example.com'))->usePort(0)->getExecuteCommand('whoami');
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can download a file', function () {
    $command = $this->ssh->getDownloadCommand('spatie.be/current/.env', '.env');
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
it('throws an exception if a port is negative')
    ->tap(fn () => (new Ssh('user', 'example.com'))->usePort(-45)->getExecuteCommand('whoami'))
    ->throws(Exception::class, 'Port must be a positive integer.');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_throws_an_exception_if_a_port_is_negative()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Port must be a positive integer.');
=======
it('can download a file', function () {
    $command = $this->ssh->getDownloadCommand('spatie.be/current/.env', '.env');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can upload a file', function () {
    $command = $this->ssh->getUploadCommand('.env', 'spatie.be/current/.env');
||||||| parent of e7a6919 (refactor: SshTest)
        $command = (new Ssh('user', 'example.com'))->usePort(-45)->getExecuteCommand('whoami');
    }
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_download_a_file()
    {
        $command = $this->ssh->getDownloadCommand('spatie.be/current/.env', '.env');
=======
it('can upload a file', function () {
    $command = $this->ssh->getUploadCommand('.env', 'spatie.be/current/.env');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
it('can run a command locally', function () {
    $local = new Ssh('user', '127.0.0.1');
    $command = $local->execute('whoami');
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    expect(get_current_user())->toEqual(trim($command->getOutput()));
||||||| parent of e7a6919 (refactor: SshTest)
    /** @test */
    public function it_can_upload_a_file()
    {
        $command = $this->ssh->getUploadCommand('.env', 'spatie.be/current/.env');
=======
it('can configure the used process', function () {
    $command = $this->ssh->configureProcess(function (Process $process) {
        $process->setTimeout(0);
    })->getExecuteCommand('whoami');
>>>>>>> e7a6919 (refactor: SshTest)

<<<<<<< HEAD
    assertMatchesSnapshot($command);
});

it('can configure the used process', function () {
    $command = $this->ssh->configureProcess(function (Process $process) {
        $process->setTimeout(0);
    })->getExecuteCommand('whoami');

    assertMatchesSnapshot($command);
});
||||||| parent of e7a6919 (refactor: SshTest)
        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_configure_the_used_process()
    {
        $command = $this->ssh->configureProcess(function (Process $process) {
            $process->setTimeout(0);
        })->getExecuteCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }
}
=======
    assertMatchesSnapshot($command);
});
>>>>>>> e7a6919 (refactor: SshTest)
