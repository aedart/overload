<?php namespace Aedart\Overload\Traits\Helper;

use Aedart\Overload\Interfaces\PropertyAccessibilityLevel;
use RangeException;
use ReflectionProperty;

/**
 * Property Accessibility Trait
 *
 * <b>Description</b><br />
 * Determine what maximum level of accessibily properties must have,
 * before they can be set or get, using PHP's magic methods; __set(), __get()
 * 
 * Methods declared inside this trait are all marked protected, because
 * it should not be allowed to change property accessibility, from an
 * outside scope.
 * 
 * <b>Default</b><br />
 * By default, properties that are declared 'protected' can be can
 * be "overloaded"
 * 
 * <b>Tip</b><br />
 * If you wish for you 'private' declared properties to be accessible
 * on a given component, then invoke <b>setPropertyAccessibilityLevel(...)</b>
 * in e.g. the __construct() method.
 * 
 * @see \Aedart\Overload\Interfaces\PropertyOverloadable
 * @see PropertyAccessibilityLevel
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait PropertyAccessibilityTrait {
    
    /**
     * The current accessibility level
     * 
     * @var integer
     */
    private $_propertyAccessibilityLevel = null;
    
    /**
     * Set the maximum level of accessibility for allowing properties
     * to be set or get
     * 
     * @see PropertyAccessibilityLevel
     * 
     * @param integer $level Property accessibility level
     * @throws RangeException If level is invalid
     */
    protected function setPropertyAccessibilityLevel($level){
	if(!$this->isPropertyAccessibilityLevelValid($level)){
	    throw new RangeException(sprintf('Property accessibility level "%s" is invalid', $level));
	}
	$this->_propertyAccessibilityLevel = $level;
    }
    
    /**
     * Get the maximum level of accessibility for allowing properties
     * to be set or get
     * 
     * If no accessibility level has been specified, this method will
     * set and return a default level.
     * 
     * @see PropertyAccessibilityTrait::getDefaultPropertyAccessibilityLevel()
     * 
     * @return integer Property accessibility level
     */
    protected function getPropertyAccessibilityLevel(){
	if(is_null($this->_propertyAccessibilityLevel)){
	    $this->setPropertyAccessibilityLevel($this->getDefaultPropertyAccessibilityLevel());
	}
	
	return $this->_propertyAccessibilityLevel;
    }
    
    /**
     * Returns a default highest property accessibility level
     * 
     * @see PropertyAccessibilityLevel
     * 
     * @return integer Default property accessibility level (<b>protected level</b>)
     */
    protected function getDefaultPropertyAccessibilityLevel(){
	return PropertyAccessibilityLevel::PROTECTED_LEVEL;
    }
    
    /**
     * Validate the given property accessibility level
     * 
     * @see PropertyAccessibilityLevel
     * 
     * @param integer $level Property accessibility level
     * 
     * @return boolean True if level is valid, false if not
     */
    protected function isPropertyAccessibilityLevelValid($level){
	$public = PropertyAccessibilityLevel::PUBLIC_LEVEL;
	$protected = PropertyAccessibilityLevel::PROTECTED_LEVEL;
	$private = PropertyAccessibilityLevel::PRIVATE_LEVEL;
	
	if(is_int($level) && ($level == $public ||$level == $protected || $level == $private)){
	    return true;
	}
	
	return false;
    }
    
    /**
     * Check if a given property is accessible; if this component is allowed
     * to use __get() / __set() to read / write the given property
     * 
     * <b>Static properties</b><br />
     * Static properties are NOT considered to be accessible, in this
     * default implementation
     * 
     * @see PropertyAccessibilityTrait::getPropertyAccessibilityLevel()
     * 
     * @param ReflectionProperty $property The given property in question
     * @return boolean True if the given property is accessible, false if not
     */
    protected function isPropertyAccessible(ReflectionProperty $property){
	$level = $this->getPropertyAccessibilityLevel();
	$modifers = $property->getModifiers();
	
	if(!$property->isStatic() && $modifers <= $level){
	    return true;
	}
	
	return false;
    }
}
