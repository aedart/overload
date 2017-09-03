<?php

use Aedart\Overload\Contracts\Properties\AccessibilityLevels;
use Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * @group property-accessibility-trait
 */
class PropertyAccessibilityTraitTest extends UnitTestCase
{
    /********************************************************************
     * Helper methods
     *******************************************************************/

    /**
     * Get a mock of the trait
     *
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getTraitMock() : PHPUnit_Framework_MockObject_MockObject
    {
        return $this->getMockForTrait(PropertyAccessibilityTrait::class);
    }

    /**
     * Returns a dummy class
     *
     * @return \PropertyAccessibilityTraitDummy
     */
    protected function getDummyClass() : PropertyAccessibilityTraitDummy
    {
        return new PropertyAccessibilityTraitDummy();
    }

    /**
     * Get a method - with its accessibility set to true
     *
     * @param string $name Method name
     * @return \ReflectionMethod
     */
    protected function getMethod(string $name) : ReflectionMethod
    {
        $class = new ReflectionClass($this->getDummyClass());
        $method = $class->getMethod($name);
        $method->setAccessible(true);
        return $method;
    }

    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     */
    public function getDefaultPropertyAccessibilityLevel()
    {
        $method = $this->getMethod('getPropertyAccessibilityLevel');
        $dummy = $this->getDummyClass();
        $this->assertEquals(AccessibilityLevels::PROTECTED_LEVEL, $method->invoke($dummy));
    }

    /**
     * @test
     */
    public function setAndGetPropertyAccessibilityLevel()
    {
        $setter = $this->getMethod('setPropertyAccessibilityLevel');
        $getter = $this->getMethod('getPropertyAccessibilityLevel');
        $dummy = $this->getDummyClass();

        $setter->invoke($dummy, AccessibilityLevels::PRIVATE_LEVEL);

        $this->assertEquals(AccessibilityLevels::PRIVATE_LEVEL, $getter->invoke($dummy));
    }

    /**
     * @test
     * @expectedException \RangeException
     */
    public function setInvalidPropertyAccessibilityLevel()
    {
        $setter = $this->getMethod('setPropertyAccessibilityLevel');
        $dummy = $this->getDummyClass();

        $setter->invoke($dummy, -42);
    }

    /**
     * @test
     */
    public function isPublicPropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->getDummyClass();
        $property = (new ReflectionClass($dummy))->getProperty('name');

        $this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }

    /**
     * @test
     */
    public function isProtectedPropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->getDummyClass();
        $property = (new ReflectionClass($dummy))->getProperty('age');

        $this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }

    /**
     * @test
     */
    public function isPrivatePropertyAccessible()
    {
        $isAccessibleMethod = $this->getMethod('isPropertyAccessible');
        $dummy = $this->getDummyClass();
        $property = (new ReflectionClass($dummy))->getProperty('height');

        // By default, protected is the highest level, so... this must be false!
        $this->assertFalse($isAccessibleMethod->invoke($dummy, $property));
    }
}

/**
 * Dummy class that uses the given trait
 */
class PropertyAccessibilityTraitDummy
{
    use PropertyAccessibilityTrait;

    public $name = 'John Doe';
    protected $age = 42;
    private $height = 193;
}