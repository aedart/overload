<?php namespace Aedart\Overload\Traits;

use Aedart\Overload\Exception\UndefinedPropertyException;

/**
 * Unset Invoker Trait
 *
 * <b>Description</b><br />
 * Implements the __unset() method
 *
 * If requested property is not available / accessible, the __unset()
 * will fail and throw an exception.
 *
 * <b>Property accessibility</b><br />
 * By default, 'protected' properties are exposed and this component will
 * search and execute unset method on those properties, if they are
 * available.
 *
 * <b>Warning</b>: This trait assumes that you are also using the ReflectionTrait.
 * A fatal error will occur if the given trait is not applied, in your component!
 *
 * @see \Aedart\Overload\Traits\Helper\ReflectionTrait
 * @see \Aedart\Overload\Interfaces\PropertyOverloadable
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait UnsetInvokerTrait {

    /**
     * Method is invoked when unset() is used on inaccessible properties.
     *
     * @param string $name Property name
     *
     * @return void
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __unset($name) {
        if ($this->hasInternalProperty($name)) {
            unset($this->$name);
            return;
        }

        throw new UndefinedPropertyException(sprintf('Property "%s" does not exist or is inaccessible', $name));
    }

}
