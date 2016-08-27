<?php

use Aedart\Overload\Interfaces\PropertyOverloadable;
use Aedart\Testing\TestCases\Unit\UnitTestCase;
use \Mockery as m;

/**
 * MockPropertyOverloadableTest
 *
 * @group integration
 * @group interfaces
 * @group property-overloadable-interface
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class MockPropertyOverloadableTest extends UnitTestCase
{
    /**
     * @test
     */
    public function canMockPropertyOverloadableInterfaceViaPhpUnit()
    {
        $this->createMock(PropertyOverloadable::class);

        $this->assertNotNull($mock);
    }

    /**
     * @test
     */
    public function canMockPropertyOverloadableInterfaceViaMockery()
    {
        $mock = m::mock(PropertyOverloadable::class);

        $this->assertNotNull($mock);
    }

}