<?php

use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Aedart\Overload\Traits\GetterInvokerTrait;
use Aedart\Overload\Traits\PropertyOverloadTrait;
use Aedart\Overload\Traits\SetterInvokerTrait;
use Aedart\Testing\TestCases\Unit\UnitTestCase;

/**
 * Class PropertyOverloadTraitTest
 *
 * @group property-overload-trait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
class PropertyOverloadTraitTest extends UnitTestCase
{

    /******************************************************************************
     * Providers
     *****************************************************************************/

    /**
     * @return AClass
     */
    protected function getAClass() : AClass
    {
        return new AClass();
    }

    /**
     * @return BClass
     */
    protected function getBClass() : BClass
    {
        return new BClass();
    }

    /******************************************************************************
     * Tests
     *****************************************************************************/

    /**
     * @test
     */
    public function usingPropertyOverloadTraits()
    {
        $x = $this->getAClass();
        $x->name = 'Jimmy';

        $this->assertSame('Jimmy', $x->name);
    }

    /**
     * @test
     */
    public function usingGetterAndSetterInvokerTraits()
    {
        $x = $this->getBClass();
        $x->name = 'Jack';

        $this->assertSame('Jack', $x->name);
    }

}

/**
 * Class AClass
 *
 * @property string $name
 */
class AClass
{
    use PropertyOverloadTrait;

    protected $name = 'Jim';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}

/**
 * Class BClass
 *
 * @property string $name
 */
class BClass
{
    use ReflectionTrait, GetterInvokerTrait, SetterInvokerTrait;

    protected $name = 'Jim';

    public function setName($name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}