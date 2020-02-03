<?php

namespace Spatie\Skeleton\Tests;

use PHPUnit\Framework\TestCase;
use Spatie\Ssh\Ssh;

class SshTest extends TestCase
{
    /** @test */
    public function the_ssh_class_can_be_instantiated()
    {
        $this->assertInstanceOf(Ssh::class, new Ssh('user', 'host'));
    }
}
