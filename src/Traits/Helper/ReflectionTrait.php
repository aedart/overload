<?php namespace Aedart\Overload\Traits\Helper;

use Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait;
use ReflectionClass;
use ReflectionProperty;

/**
 * Reflection Trait
 *
 * <b>Description</b><br />
 * Provides some utility methods for obtaining information about
 * a components properties available, their accessibility (in overloading
 * context)
 * 
 * @see PropertyAccessibilityTrait
 * @see \Aedart\Overload\Interfaces\PropertyAccessibilityLevel
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait ReflectionTrait {
    
    use PropertyAccessibilityTrait;
    
    /**
     * Check if this component has an internal property with the
     * given name and if its accessible for "overloading";
     * if it can be accessed via __get(), __set() methods
     * 
     * @see PropertyAccessibilityTrait::getPropertyAccessibilityLevel()
     * @see \Aedart\Overload\Interfaces\PropertyAccessibilityLevel
     * 
     * @param string $name Property name
     * @return boolean True if property exists and is accessible for "overloading"
     */
    protected function hasInternalProperty($name){
	$reflection = new ReflectionClass($this);
	if($reflection->hasProperty($name)){
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
     * @see \Aedart\Overload\Interfaces\PropertyAccessibilityLevel
     * 
     * @param string $name Property name
     * @return ReflectionProperty The given property
     */
    protected function getInternalProperty($name){
	return (new ReflectionClass($this))->getProperty($name);
    }
    
    /**
     * Check if this component has a method of the given name
     * 
     * @param string $name Method name
     * @return boolean True if method exists, false if not
     */
    protected function hasInternalMethod($name){
	return (new ReflectionClass($this))->hasMethod($name);
    }
}
