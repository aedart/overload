<?php
declare(strict_types=1);

namespace Aedart\Overload\Traits;

use Aedart\Overload\Exception\UndefinedPropertyException;
use Illuminate\Support\Str;
use ReflectionProperty;

/**
 * Setter Invoker Trait
 *
 * <br />
 *
 * Implements the __set() method, by looking for a requested property's
 * corresponding setter-method and invokes it, if available.
 *
 * <br />
 *
 * If no getter method is available, the __set() will fail and throw an
 * exception.
 *
 * <br />
 *
 * <b>Property accessibility</b>
 * By default, 'protected' properties are exposed and this component will
 * search and execute setter methods for those properties, if they are
 * available.
 *
 * <br />
 *
 * <b>Warning</b>: This trait assumes that you are also using the ReflectionTrait.
 * A fatal error will occur if the given trait is not applied, in your component!
 *
 * @see \Aedart\Overload\Traits\Helper\ReflectionTrait
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait SetterInvokerTrait
{
    /**
     * Method is run when writing data to inaccessible properties.
     *
     * @param string $name Property name
     * @param mixed $value Property value
     *
     * @return void
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __set(string $name, $value) : void
    {
        if ($this->hasInternalProperty($name)) {
            $this->invokeSetter($this->getInternalProperty($name), $value);
            return;
        }

        throw new UndefinedPropertyException(sprintf('Property "%s" does not exist or is inaccessible', $name));
    }

    /**
     * Invoke the given property's setter-method
     *
     * @param ReflectionProperty $property The property in question
     * @param mixed $value The property's value
     *
     * @return void;
     * @throws UndefinedPropertyException If given property doesn't have a corresponding get
     */
    protected function invokeSetter(ReflectionProperty $property, $value) : void
    {
        $methodName = $this->generateSetterName($property->getName());
        if ($this->hasInternalMethod($methodName)) {
            $this->$methodName($value);
            return;
        }

        throw new UndefinedPropertyException(sprintf(
            'No "%s"() method available for property "%s"', $methodName,
            $property->getName()
        ));
    }

    /**
     * Generate and return a 'setter' name, based upon the given
     * property name
     *
     * <b>Example</b><br />
     * <pre>
     *        $propertyName = 'logger';
     *        return generateSetterName($propertyName) // Returns setLogger
     * </pre>
     *
     * @param string $propertyName Name of a given property
     *
     * @return string Setter method name
     */
    protected function generateSetterName(string $propertyName) : string
    {
        static $methods = [];

        if (isset($methods[$propertyName])) {
            return $methods[$propertyName];
        }

        $method = 'set' . ucfirst(Str::camel($propertyName));
        $methods[$propertyName] = $method;

        return $method;
    }
}
