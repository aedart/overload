<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Aedart\Overload\Traits\UnsetInvokerTrait;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * @group unset-invoker-trait
 */
class UnsetInvokerTraitTest extends UnitTestCase
{

    /********************************************************************
     * Helper methods
     *******************************************************************/

    /**
     * Returns a dummy class
     * @return \UnsetDummy
     */
    protected function getDummyClass() : UnsetDummy
    {
        return new UnsetDummy();
    }

    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     */
    public function unsetProperty()
    {
        $dummy = $this->getDummyClass();
        unset($dummy->name);
        $this->assertFalse($dummy->isPropSet('name'));
    }

    /**
     * @test
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function attemptUnsetNoneExistingProperty()
    {
        $dummy = $this->getDummyClass();
        unset($dummy->age);
    }
}

/**
 * Dummy class that uses given trait
 *
 * @property string $name
 */
class UnsetDummy
{

    use ReflectionTrait, UnsetInvokerTrait;

    protected $name = 'Lilla Henrikson';

    public function isPropSet($propName)
    {
        return isset($this->$propName);
    }
}