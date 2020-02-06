<?php

namespace Spatie\Ssh\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\Ssh\Ssh;

class SshTest extends TestCase
{
    use MatchesSnapshots;

    private Ssh $ssh;

    public function setUp(): void
    {
        parent::setUp();

        $this->ssh = (new Ssh('user', 'example.com'));
    }

    /** @test */
    public function it_can_run_a_single_command()
    {
        $command = $this->ssh->useCustomKnownHostsFileLocation('/tmp/test')->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_run_multiple_commands()
    {
        $command = $this->ssh->useCustomKnownHostsFileLocation('/tmp/test')->getSshCommand(['whoami', 'cd /var/log']);

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_use_a_specific_private_key()
    {
        $command = $this->ssh->useCustomKnownHostsFileLocation('/tmp/test')->usePrivateKey('/home/user/.ssh/id_rsa')->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_constructor()
    {
        $command = (new Ssh('user', 'example.com', 123))->useCustomKnownHostsFileLocation('/tmp/test')->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_dedicated_function()
    {
        $command = (new Ssh('user', 'example.com'))->useCustomKnownHostsFileLocation('/tmp/test')->usePort(123)->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_instantiate_via_the_create_method()
    {
        $this->assertInstanceOf(Ssh::class, Ssh::create('user', 'example.com'));
    }

    /** @test */
    public function it_can_disable_strict_host_checking()
    {
        $command = (new Ssh('user', 'example.com'))->disableStrictHostKeyChecking()->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }
}
