<?php

namespace App\Tests\TestCase;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\Container;

/**
 * Class AbstractControllerTestCase
 * @package App\Tests\TestCase
 */
abstract class AbstractApplicationTestCase extends KernelTestCase
{
    /** @var Container $container 
     */
    protected Container $container;

    /**
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();
        self::bootKernel(["environment" => "test"]);
        $this->container = static::getContainer();
    }

    /**
     * @return void
     */
    public function tearDown(): void
    {
        parent::tearDown();
    }
}
