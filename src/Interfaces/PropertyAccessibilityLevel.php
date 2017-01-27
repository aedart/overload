<?php namespace Aedart\Overload\Interfaces;

use ReflectionProperty;

/**
 * Property Accessibility
 *
 * <b>Description</b><br />
 * Defines the property accessibility levels, which can be
 * used to determine if a property is allowed to be accessed
 * or not.
 *
 * This interface is mostly usefull in the context of "overloading"
 * properties dynamically.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
interface PropertyAccessibilityLevel
{

    /**
     * Public level - no 'protected' nor 'private' properties
     * are going to be automatically get / set
     */
    const PUBLIC_LEVEL = ReflectionProperty::IS_PUBLIC;

    /**
     * Protected level - properties that are declared
     * 'protected' can be set / get.
     */
    const PROTECTED_LEVEL = ReflectionProperty::IS_PROTECTED;

    /**
     * Private level - properties that are declared
     * 'protected' or 'private' can be set / get.
     */
    const PRIVATE_LEVEL = ReflectionProperty::IS_PRIVATE;
}
