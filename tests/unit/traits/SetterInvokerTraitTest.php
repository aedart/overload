<?php

use Aedart\Overload\Traits\SetterInvokerTrait;

/**
 * @coversDefaultClass Aedart\Overload\Traits\SetterInvokerTrait
 */
class SetterInvokerTraitTest extends \Codeception\TestCase\Test
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
     * @return \SetterInvokerDummy
     */
    protected function getDummyClass(){
	return new SetterInvokerDummy();
    }
        
    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     * @covers ::__set
     * @covers ::invokeSetter
     * @covers ::generateSetterName
     */
    public function setAccessibleProperty(){
	$dummy = $this->getDummyClass();
	$newName = 'Andrew Brewman';
	
	$dummy->name = $newName;
	
	$this->assertSame($newName, $dummy->getName());
    }
    
    /**
     * @test
     * @covers ::__set
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function setNoneExistingProperty(){
	$dummy = $this->getDummyClass();
	$dummy->age = 98;	
    }
    
    /**
     * @test
     * @covers ::__set
     * @covers ::invokeSetter
     * @covers ::generateSetterName
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function attemptPropertyWriteWithoutSetter(){
	$dummy = $this->getDummyClass();
	$dummy->propWithoutSetter = 'Brian Conner';
    }
}

/**
 * Dummy class for given trait
 * 
 * @property string $name Name of a person
 */
class SetterInvokerDummy {
    
    use SetterInvokerTrait;
 
    protected $name = 'Drew Fishmoon';
    protected $propWithoutSetter = 'Bar Foo';
    
    public function setName($value){
	$this->name = $value;
    }
    
    public function getName(){
	return $this->name;
    }
}