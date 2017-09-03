<?php namespace Aedart\Overload\Interfaces;

use Aedart\Overload\Contracts\Properties\AccessibilityLevels;

/**
 * @deprecated Since 4.0, use \Aedart\Overload\Contracts\Properties\AccessibilityLevels instead
 *
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
interface PropertyAccessibilityLevel extends AccessibilityLevels
{

}
