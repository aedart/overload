<?php namespace Aedart\Overload\Traits;

use Aedart\Overload\Traits\GetterInvokerTrait;
use Aedart\Overload\Traits\SetterInvokerTrait;
use Aedart\Overload\Traits\IssetInvokerTrait;
use Aedart\Overload\Traits\UnsetInvokerTrait;

/**
 * Property Overload Trait
 * 
 * @todo Description of PropertyOverloadTrait
 * 
 * @see \Aedart\Overload\Interfaces\PropertyOverloadable
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 * 
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait PropertyOverloadTrait {
    
    use GetterInvokerTrait, SetterInvokerTrait, IssetInvokerTrait, UnsetInvokerTrait;
}
