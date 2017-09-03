<?php
declare(strict_types=1);

namespace Aedart\Overload\Traits;

/**
 * Isset Invoker Trait
 *
 * <br />
 *
 * Implements the __isset() method
 *
 * <br />
 *
 * <b>Property accessibility</b>
 * By default, 'protected' properties are exposed and this component will
 * search and execute isset method on those properties, if they are
 * available. If not, then the __isset() will return false
 *
 * <br />
 *
 * <b>Warning</b>: This trait assumes that you are also using the ReflectionTrait.
 * A fatal error will occur if the given trait is not applied, in your component!
 *
 * @see \Aedart\Overload\Traits\Helper\ReflectionTrait
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 * @see http://php.net/manual/en/function.isset.php
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait IssetInvokerTrait
{
    /**
     * Method is triggered by calling isset() or empty() on inaccessible properties.
     *
     * If an undefined property is being checked, using isset or empty, then
     * this method will always return false
     *
     * @param string $name Property name
     *
     * @return boolean True if property isset, false if not OR if property is undefined
     */
    public function __isset(string $name) : bool
    {
        if ($this->hasInternalProperty($name)) {
            return isset($this->$name);
        }
        return false;
    }
}
