<?php

namespace Spatie\Skeleton\Tests;

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
        $command = $this->ssh->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_run_multiple_commands()
    {
        $command = $this->ssh->getSshCommand(['whoami', 'cd /var/log']);

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_use_a_specific_private_key()
    {
        $command = $this->ssh->usePrivateKey('/home/user/.ssh/id_rsa')->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_constructor()
    {
        $command = (new Ssh('user', 'example.com', 123))->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_dedicated_function()
    {
        $command = (new Ssh('user', 'example.com'))->port(123)->getSshCommand('whoami');

        $this->assertMatchesSnapshot($command);
    }
}
