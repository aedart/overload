<?php

use Aedart\Overload\Traits\UnsetInvokerTrait;

/**
 * @coversDefaultClass Aedart\Overload\Traits\UnsetInvokerTrait
 */
class UnsetInvokerTraitTest extends \Codeception\TestCase\Test
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
     * Returns a dummy class
     * @return \UnsetDummy
     */
    protected function getDummyClass(){
	return new UnsetDummy();
    }
        
    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     * @covers ::__unset
     */
    public function unsetProperty(){
	$dummy = $this->getDummyClass();
	unset($dummy->name);
	$this->assertFalse($dummy->isPropSet('name'));
    }
        
    /**
     * @test
     * @covers ::__unset
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function attemptUnsetNoneExistingProperty(){
	$dummy = $this->getDummyClass();
	unset($dummy->age);	
    }
}

/**
 * Dummy class that uses given trait
 *
 * @property string $name
 */
class UnsetDummy {
    
    use UnsetInvokerTrait;
    
    protected $name = 'Lilla Henrikson';
    
    public function isPropSet($propName){
	return isset($this->$propName);
    }
}