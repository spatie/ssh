<?php

namespace Spatie\Ssh\Tests;

use Exception;
use PHPUnit\Framework\TestCase;
use Spatie\Snapshots\MatchesSnapshots;
use Spatie\Ssh\Scp;

class ScpTest extends TestCase
{
    use MatchesSnapshots;

    private Scp $scp;

    public function setUp(): void
    {
        parent::setUp();

        $this->scp = (new Scp('user', 'example.com'));
    }

    /** @test */
    public function it_can_download_a_file()
    {
        $command = $this->scp->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_upload_a_file()
    {
        $command = $this->scp->getUploadCommand('.env', 'spatie.be/current/.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_use_a_specific_private_key()
    {
        $command = $this->scp
            ->usePrivateKey('/home/user/.ssh/id_rsa')
            ->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_constructor()
    {
        $command = (new Scp('user', 'example.com', 123))->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_set_the_port_via_the_dedicated_function()
    {
        $command = (new Scp('user', 'example.com'))
            ->usePort(123)
            ->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_instantiate_via_the_create_method()
    {
        $this->assertInstanceOf(Scp::class, Scp::create('user', 'example.com'));
    }

    /** @test */
    public function it_can_disable_strict_host_checking()
    {
        $command = $this->scp
            ->disableStrictHostKeyChecking()
            ->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_can_enable_strict_host_checking()
    {
        $command = $this->scp
            ->enableStrictHostKeyChecking()
            ->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function zero_is_a_valid_port_number()
    {
        $command = $this->scp->usePort(0)->getDownloadCommand('spatie.be/current/.env', '.env');

        $this->assertMatchesSnapshot($command);
    }

    /** @test */
    public function it_throws_an_exception_if_a_port_is_negative()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Port must be a positive integer.');

        $command = (new Scp('user', 'example.com'))->usePort(-45)->getDownloadCommand('spatie.be/current/.env', '.env');
    }
}
