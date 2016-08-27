<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Aedart\Overload\Traits\IssetInvokerTrait;

/**
 * @coversDefaultClass Aedart\Overload\Traits\IssetInvokerTrait
 */
class IssetInvokerTraitTest extends \Codeception\TestCase\Test
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
     * @return \IssetDummy
     */
    protected function getDummyClass()
    {
        return new IssetDummy();
    }

    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     * @covers ::__isset
     */
    public function propertyIsset()
    {
        $dummy = $this->getDummyClass();
        $this->assertTrue(isset($dummy->name));
    }

    /**
     * @test
     * @covers ::__isset
     */
    public function propertyIsNotSet()
    {
        $dummy = $this->getDummyClass();
        $dummy->unsetName();
        $this->assertFalse(isset($dummy->name));
    }

    /**
     * @test
     * @covers ::__isset
     */
    public function issetOfNoneExistingProperty()
    {
        $dummy = $this->getDummyClass();
        $this->assertFalse(isset($dummy->age));
    }
}

/**
 * Dummy class for given trait
 *
 * @property string $name
 */
class IssetDummy
{

    use ReflectionTrait, IssetInvokerTrait;

    protected $name = 'Jill Anderson';

    public function unsetName()
    {
        unset($this->name);
    }
}