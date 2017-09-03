<?php
declare(strict_types=1);

namespace Aedart\Overload\Traits\Helper;

use ReflectionClass;
use ReflectionProperty;

/**
 * Reflection Trait
 *
 * <br />
 *
 * Provides some utility methods for obtaining information about
 * a components properties available, their accessibility (in overloading
 * context)
 *
 * @see PropertyAccessibilityTrait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait ReflectionTrait
{
    use PropertyAccessibilityTrait;

    /**
     * Check if this component has an internal property with the
     * given name and if its accessible for "overloading";
     * if it can be accessed via __get(), __set() methods
     *
     * @see PropertyAccessibilityTrait::getPropertyAccessibilityLevel()
     *
     * @param string $name Property name
     *
     * @return boolean True if property exists and is accessible for "overloading"
     */
    protected function hasInternalProperty(string $name) : bool
    {
        $reflection = new ReflectionClass($this);
        if ($reflection->hasProperty($name)) {
            return $this->isPropertyAccessible($reflection->getProperty($name));
        }
        return false;
    }

    /**
     * Get internal property which has the given name
     *
     * <b>Warning</b><br />
     * Method doesn't check accessibility
     *
     * @see ReflectionTrait::hasInternalProperty($name)
     *
     * @param string $name Property name
     *
     * @return ReflectionProperty The given property
     */
    protected function getInternalProperty(string $name) : ReflectionProperty
    {
        return (new ReflectionClass($this))->getProperty($name);
    }

    /**
     * Check if this component has a method of the given name
     *
     * @param string $name Method name
     *
     * @return boolean True if method exists, false if not
     */
    protected function hasInternalMethod(string $name) : bool
    {
        static $methods = [];

        $class = get_class($this);
        if (isset($methods[$class][$name])) {
            return $methods[$class][$name];
        }

        $hasMethod = (new ReflectionClass($this))->hasMethod($name);
        $methods[$class][$name] = $hasMethod;

        return $hasMethod;
    }
}
