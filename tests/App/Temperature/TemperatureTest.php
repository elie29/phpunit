<?php
namespace App\Temperature;

use PHPUnit\Framework\TestCase;
use Mockery;

/**
 * Temperature test case.
 */
class TemperatureTest extends TestCase
{

    public function tearDown()
    {
        Mockery::close();
    }

    /**
     * No auto completion
     * Code too complicated
     */
    public function testGetsAverageUsingNativeMock()
    {
        $service = $this->getMockBuilder(TemperatureServiceInterface::class)
            ->getMock();
        $service->method('readTemp')
            ->will($this->onConsecutiveCalls(10, 12, 14));

        $temperature = new Temperature($service);

        assertThat(12, is($temperature->average()));
    }

    /**
     * Code completion
     */
    public function testGetsAverageUsingMockery()
    {
        $service = Mockery::mock(TemperatureServiceInterface::class);
        $service->shouldReceive('readTemp')->times(3)->andReturn(10, 12, 14);

        $temperature = new Temperature($service);

        assertThat(12, is($temperature->average()));
    }

}