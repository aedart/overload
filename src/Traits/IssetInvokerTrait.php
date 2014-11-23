<?php namespace Aedart\Overload\Traits;

use Aedart\Overload\Traits\Helper\ReflectionTrait;

/**
 * Isset Invoker Trait
 *
 * <b>Description</b><br />
 * Implements the __isset() method
 * 
 * <b>Property accessibility</b><br />
 * By default, 'protected' properties are exposed and this component will
 * search and execute isset method on those properties, if they are
 * available. If not, then the __isset() will return false
 * 
 * @see \Aedart\Overload\Interfaces\PropertyOverloadable
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 * @see http://php.net/manual/en/function.isset.php
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait IssetInvokerTrait {

    use ReflectionTrait;
    
    /**
     * Method is triggered by calling isset() or empty() on inaccessible properties. 
     * 
     * If an undefined property is being checked, using isset or empty, then
     * this method will always return false
     * 
     * @param string $name Property name
     * @return boolean True if property isset, false if not OR if property is undefined
     */
    public function __isset($name){
	if($this->hasInternalProperty($name)){
	    return isset($this->$name);
	}
	return false;
    }
}
