<?php

namespace Aedart\Overload\Contracts\Properties;

use ReflectionProperty;

/**
 * @deprecated Use \Aedart\Contracts\Properties\AccessibilityLevels instead, in aedart/athenaeum package
 *
 * Properties Accessibility Levels
 *
 * <br />
 *
 * Defines the property accessibility levels, which can be
 * used to determine if a property is allowed to be accessed
 * or not.
 *
 * <br />
 *
 * This interface is mostly useful in the context of "overloading"
 * properties dynamically.
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 * @package Aedart\Overload\Contracts\Properties
 */
interface AccessibilityLevels
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
