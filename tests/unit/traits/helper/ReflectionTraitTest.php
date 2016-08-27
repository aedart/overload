<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;

/**
 * @coversDefaultClass Aedart\Overload\Traits\Helper\ReflectionTrait
 */
class ReflectionTraitTest extends \Codeception\TestCase\Test
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
     * @return \ReflectionTraitDummy
     */
    protected function getDummyClass()
    {
        return new ReflectionTraitDummy();
    }

    /**
     * Get a method - with its accessibility set to true
     * @param string $name Method name
     * @return \ReflectionMethod
     */
    protected function getMethod($name)
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
     * @covers ::hasInternalMethod
     */
    public function hasInternalMethod()
    {
        $method = $this->getMethod('hasInternalMethod');
        $dummy = $this->getDummyClass();
        $this->assertTrue($method->invoke($dummy, 'myInternalMethod'));
    }

    /**
     * @test
     * @covers ::getInternalProperty
     */
    public function getInternalProperty()
    {
        $method = $this->getMethod('getInternalProperty');
        $dummy = $this->getDummyClass();

        $property = $method->invoke($dummy, 'name');
        $property->setAccessible(true);

        $this->assertSame('Rick Johnson', $property->getValue($dummy));
    }

    /**
     * @test
     * @covers ::hasInternalProperty
     */
    public function doesNotHaveInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->getDummyClass();

        // This property doesn't exist
        $this->assertFalse($method->invoke($dummy, 'job'));
    }

    /**
     * @test
     * @covers ::hasInternalProperty
     */
    public function hasAccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->getDummyClass();

        // By default only protected properties should be flagged accessible
        $this->assertTrue($method->invoke($dummy, 'name'));
    }

    /**
     * @test
     * @covers ::hasInternalProperty
     */
    public function hasInaccessibleInternalProperty()
    {
        $method = $this->getMethod('hasInternalProperty');
        $dummy = $this->getDummyClass();

        // By default only protected properties should be flagged accessible - not private
        $this->assertFalse($method->invoke($dummy, 'age'));
    }
}

/**
 * Dummy class that uses the Reflection trait
 */
class ReflectionTraitDummy
{

    use ReflectionTrait;

    protected $name = 'Rick Johnson';
    private $age = 55;

    protected function myInternalMethod()
    {
        return false;
    }

}