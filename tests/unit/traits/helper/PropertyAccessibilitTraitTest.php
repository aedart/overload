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
     */
    public function getDefaultPropertyAccessibilityLevel(){
	$method = $this->getMethod('getPropertyAccessibilityLevel');
	$dummy = $this->getDummyClass();
	$this->assertEquals(PropertyAccessibilityLevel::PROTECTED_LEVEL, $method->invoke($dummy));
    }
    
    
}

/**
 * Dummy class that uses the given trait
 */
class PropertyAccessibilityTraitDummy {
    use PropertyAccessibilityTrait;
}