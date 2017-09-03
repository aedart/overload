<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Aedart\Overload\Traits\SetterInvokerTrait;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * @group setter-invoker-trait
 */
class SetterInvokerTraitTest extends UnitTestCase
{

    /********************************************************************
     * Helper methods
     *******************************************************************/

    /**
     * Returns a dummy class
     * @return \SetterInvokerDummy
     */
    protected function getDummyClass() : SetterInvokerDummy
    {
        return new SetterInvokerDummy();
    }

    /********************************************************************
     * Actual tests
     *******************************************************************/

    /**
     * @test
     */
    public function setAccessibleProperty()
    {
        $dummy = $this->getDummyClass();
        $newName = 'Andrew Brewman';

        $dummy->name = $newName;

        $this->assertSame($newName, $dummy->getName());
    }

    /**
     * @test
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function setNoneExistingProperty()
    {
        $dummy = $this->getDummyClass();
        $dummy->age = 98;
    }

    /**
     * @test
     * @expectedException Aedart\Overload\Exception\UndefinedPropertyException
     */
    public function attemptPropertyWriteWithoutSetter()
    {
        $dummy = $this->getDummyClass();
        $dummy->propWithoutSetter = 'Brian Conner';
    }
}

/**
 * Dummy class for given trait
 *
 * @property string $name Name of a person
 */
class SetterInvokerDummy
{
    use ReflectionTrait, SetterInvokerTrait;

    protected $name = 'Drew Fishmoon';
    protected $propWithoutSetter = 'Bar Foo';

    public function setName($value)
    {
        $this->name = $value;
    }

    public function getName()
    {
        return $this->name;
    }
}