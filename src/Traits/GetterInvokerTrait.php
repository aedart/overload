<?php namespace Aedart\Overload\Traits;

use Aedart\Overload\Exception\UndefinedPropertyException;
use Aedart\Overload\Traits\Helper\ReflectionTrait;
use Illuminate\Support\Str;
use ReflectionProperty;

/**
 * Getter Invoker Trait
 *
 * <b>Description</b><br />
 * Implements the __get() method, by looking for a requested property's
 * corresponding getter-method and invokes it, if available.
 * 
 * If no getter method is available, the __get() will fail and throw an
 * exception.
 * 
 * <b>Property accessibility</b><br />
 * By default, 'protected' properties are exposed and this component will
 * search and execute getter methods for those properties, if they are
 * available.
 * 
 * @see \Aedart\Overload\Interfaces\PropertyOverloadable
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait GetterInvokerTrait {
    
    use ReflectionTrait;
    
    /**
     * Method is utilized for reading data from inaccessible properties.
     * 
     * @param string $name Property name
     * @return mixed Property value
     * @throws UndefinedPropertyException If property doesn't exist
     */
    public function __get($name){
	if($this->hasInternalProperty($name)){
	    return $this->invokeGetter($this->getInternalProperty($name));
	}
	
	throw new UndefinedPropertyException(sprintf('Property "%s" does not exist or is inaccessible', $name));
    }
    
    /**
     * Invoke and return the given property's getter-method
     * 
     * @param ReflectionProperty $property The property in question
     * @return mixed Property value
     * @throws UndefinedPropertyException If given property doesn't have a corresponding get
     */
    protected function invokeGetter(ReflectionProperty $property){
	if($this->hasGetterFor($property)){
	    $methodName = $this->generateGetterName($property->getName());
	    return $this->$methodName();
	}
	
	throw new UndefinedPropertyException(sprintf('No "%s"() method available for property "%s"', $methodName, $property->getName()));
    }

    /**
     * Check if the given property has a corresponding getter-method
     * 
     * @param ReflectionProperty $property The property in question
     * @return boolean True if a getter method exists for the given property
     */
    protected function hasGetterFor(ReflectionProperty $property){
	$methodName = $this->generateGetterName($property->getName());
	return $this->hasInternalMethod($methodName);
    }

    /**
     * Generate and return a 'getter' name, based upon the given
     * property name
     * 
     * <b>Example</b><br />
     * <pre>
     *	    $propertyName = 'logger';
     *	    return generateGetterName($propertyName) // Returns getLogger
     * </pre>
     * 
     * @param string $propertyName Name of a given property
     * @return string Getter method name
     */
    protected function generateGetterName($propertyName){
	return 'get' . ucfirst(Str::camel($propertyName));
    }
}
