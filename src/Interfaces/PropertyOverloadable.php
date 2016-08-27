<?php namespace Aedart\Overload\Interfaces;

use Aedart\Overload\Exception\UndefinedPropertyException;

/**
 * @deprecated Will be removed in version 3.0. Interface has proved to yield mocking problems, manually tested via PHPUnit's mocking and Mockery!
 *
 * Property Overloadable
 *
 * <b>Description</b><br />
 * Provides means to somehow, dynamically, deal with inaccessible
 * properties, using PHP's magic methods; __set(), __get(), __isset()
 * and __unset().
 *
 * <b>Undefined Property Exception</b><br />
 * How inaccessible properties are being handled, e.g. created on the fly
 * or no at all, is entirely implementation dependent. If a given component
 * doesn't allow certain properties to be created or obtained, then an
 * "undefined property"-exception should be thrown
 *
 * <b>Tip</b><br />
 * If the given class / object / component makes use of such, it is
 * recommended that those properties are documented, using PHPDoc's
 * "property"-tag. Doing so, code-completion will be enabled in many
 * IDEs.
 *
 * @see http://php.net/manual/en/language.oop5.overloading.php PHP's documentation on "overloading"
 * @see http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html PHPDoc property
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
interface PropertyOverloadable
{

    /**
     * Method is run when writing data to inaccessible properties.
     *
     * @param string $name Property name
     * @param mixed $value Property value
     * @return void
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __set($name, $value);

    /**
     * Method is utilized for reading data from inaccessible properties.
     *
     * @param string $name Property name
     * @return mixed Property value
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __get($name);

    /**
     * Method is triggered by calling isset() or empty() on inaccessible properties.
     *
     * If an undefined property is being checked, using isset or empty, then
     * this method will always return false
     *
     * @see http://php.net/manual/en/function.isset.php
     *
     * @param string $name Property name
     * @return boolean True if property isset, false if not OR if property is undefined
     */
    public function __isset($name);

    /**
     * Method is invoked when unset() is used on inaccessible properties.
     *
     * @param string $name Property name
     * @return void
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __unset($name);
}
