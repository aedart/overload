<?php

use Aedart\Overload\Traits\GetterInvokerTrait;

/**
 * @coversDefaultClass Aedart\Overload\Traits\GetterInvokerTrait
 */
class GetterInvokerTraitTest extends \Codeception\TestCase\Test
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
     * @return \GetterInvokerDummy
     */
    protected function getDummyClass(){
	return new GetterInvokerDummy();
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
     * @covers ::__get
     * @covers ::invokeGetter
     * @covers ::generateGetterName
     */
    public function getAccessibleProperty(){
	$dummy = $this->getDummyClass();
	$this->assertSame('Jimmy Nielsen', $dummy->name);
    }
    
    /**
     * @test
     * @covers ::__get
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function getNoneExistingProperty(){
	$dummy = $this->getDummyClass();
	$x = $dummy->address;
    }

    /**
     * @test
     * @covers ::__get
     * @covers ::invokeGetter
     * @covers ::generateGetterName
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function attemptPropertyReadWithoutGetter(){
	$dummy = $this->getDummyClass();
	$x = $dummy->propWithoutGetter;	
    }
}

/**
 * Dummy class that uses the given trait
 * 
 * @property string $name Name of some person
 */
class GetterInvokerDummy{
    use GetterInvokerTrait;
    
    protected $name = 'Jimmy Nielsen';
    protected $propWithoutGetter = 'Foo Bar';
    
    public function getName(){
	return $this->name;
    }
}