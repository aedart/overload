<?php namespace Aedart\Overload;

use Aedart\Overload\Exception\UndefinedPropertyException;

/**
 * Property Overloadable
 * 
 * Provides means to somehow, dynamically, deal with inaccessible
 * properties, using PHP's magic methods; __set(), __get(), __isset()
 * and __unset().
 * 
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
interface IPropertyOverloadable {
    
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
