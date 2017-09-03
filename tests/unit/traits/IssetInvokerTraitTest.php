<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Aedart\Overload\Traits\IssetInvokerTrait;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * @group isset-invoker-trait
 */
class IssetInvokerTraitTest extends UnitTestCase
{

    /********************************************************************
     * Helper methods
     *******************************************************************/

    /**
     * Returns a dummy class
     * @return \IssetDummy
     */
    protected function getDummyClass() : IssetDummy
    {
        return new IssetDummy();
    }

    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     */
    public function propertyIsset()
    {
        $dummy = $this->getDummyClass();
        $this->assertTrue(isset($dummy->name));
    }

    /**
     * @test
     */
    public function propertyIsNotSet()
    {
        $dummy = $this->getDummyClass();
        $dummy->unsetName();
        $this->assertFalse(isset($dummy->name));
    }

    /**
     * @test
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