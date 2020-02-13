<?php

namespace Spatie\Ssh\Tests;

use Exception;
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
        $command = $this->ssh->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_run_multiple_commands()
    {
        $command = $this->ssh->getCommand(['whoami', 'cd /var/log']);

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_use_a_specific_private_key()
    {
        $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_constructor()
    {
        $command = (new Ssh('user', 'example.com', 123))->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_dedicated_function()
    {
        $command = (new Ssh('user', 'example.com'))->usePort(123)->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_instantiate_via_the_create_method()
    {
        $this->assertInstanceOf(Ssh::class, Ssh::create('user', 'example.com'));
    }

    /** @test */
    public function it_can_enable_strict_host_checking()
    {
        $command = (new Ssh('user', 'example.com'))->enableStrictHostKeyChecking()->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function zero_is_a_valid_port_number()
    {
        $command = (new Ssh('user', 'example.com'))->usePort(0)->getCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_throws_an_exception_if_a_port_is_negative()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Port must be a positive integer.');

        $command = (new Ssh('user', 'example.com'))->usePort(-45)->getCommand('whoami');
    }
}
