<?php

use Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait;
use Aedart\Overload\Interfaces\PropertyAccessibilityLevel;

/**
 * @coversDefaultClass Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 */
class PropertyAccessibilitTraitTest extends \Codeception\TestCase\Test
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
    }

    protected function _after()
    {
    }

    /********************************************************************
     * Helper methods
     *******************************************************************/

    /**
     * Get a mock of the trait
     * @return PHPUnit_Framework_MockObject_MockObject
     */
    protected function getTraitMock(){
	$m = $this->getMockForTrait('Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait');
	return $m;
    }
    
    /**
     * Returns a dummy class
     * @return \PropertyAccessibilityTraitDummy
     */
    protected function getDummyClass(){
	return new PropertyAccessibilityTraitDummy();
    }
    
    /**
     * Get a method - with its accessibility set to true
     * @param string $name Method name
     * @return \ReflectionMethod
     */
    protected function getMethod($name){
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
     * @covers ::getDefaultPropertyAccessibilityLevel
     * @covers ::getPropertyAccessibilityLevel
     * @covers ::setPropertyAccessibilityLevel
     * @covers ::isPropertyAccessibilityLevelValid
     */
    public function getDefaultPropertyAccessibilityLevel(){
	$method = $this->getMethod('getPropertyAccessibilityLevel');
	$dummy = $this->getDummyClass();
	$this->assertEquals(PropertyAccessibilityLevel::PROTECTED_LEVEL, $method->invoke($dummy));
    }
    
    /**
     * @test
     * @covers ::getPropertyAccessibilityLevel
     * @covers ::setPropertyAccessibilityLevel
     * @covers ::isPropertyAccessibilityLevelValid
     */
    public function setAndGetPropertyAccessibilityLevel(){
	$setter = $this->getMethod('setPropertyAccessibilityLevel');
	$getter = $this->getMethod('getPropertyAccessibilityLevel');
	$dummy = $this->getDummyClass();
	
	$setter->invoke($dummy, PropertyAccessibilityLevel::PRIVATE_LEVEL);
	
	$this->assertEquals(PropertyAccessibilityLevel::PRIVATE_LEVEL, $getter->invoke($dummy));
    }

    /**
     * @test
     * @covers ::setPropertyAccessibilityLevel
     * @covers ::isPropertyAccessibilityLevelValid
     * @expectedException \RangeException
     */
    public function setInvalidPropertyAccessibilityLevel(){
	$setter = $this->getMethod('setPropertyAccessibilityLevel');
	$dummy = $this->getDummyClass();
	
	$setter->invoke($dummy, -42);
    }

    /**
     * @test
     * @covers ::isPropertyAccessible
     */
    public function isPublicPropertyAccessible(){
	$isAccessibleMethod = $this->getMethod('isPropertyAccessible');
	$dummy = $this->getDummyClass();
	$property = (new ReflectionClass($dummy))->getProperty('name');
	
	$this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }
    
    /**
     * @test
     * @covers ::isPropertyAccessible
     */
    public function isProtectedPropertyAccessible(){
	$isAccessibleMethod = $this->getMethod('isPropertyAccessible');
	$dummy = $this->getDummyClass();
	$property = (new ReflectionClass($dummy))->getProperty('age');
	
	$this->assertTrue($isAccessibleMethod->invoke($dummy, $property));
    }
    
    /**
     * @test
     * @covers ::isPropertyAccessible
     */
    public function isPrivatePropertyAccessible(){
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
class PropertyAccessibilityTraitDummy {
    
    public $name = 'John Doe';
    protected $age = 42;
    private $height = 193;
    
    use PropertyAccessibilityTrait;
}