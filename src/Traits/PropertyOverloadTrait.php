<?php
declare(strict_types=1);

namespace Aedart\Overload\Traits;

use Aedart\Overload\Traits\Helper\ReflectionTrait;

/**
 * Property Overload Trait
 *
 * <br />
 *
 * Composite trait, which implements PHP's magic methods for "overloading"
 * properties. Each property, however, have a defined getter and setter
 * method implemented, or the give component will fail reads or writes
 * attempts, on the given property
 *
 * @see \Aedart\Overload\Traits\GetterInvokerTrait
 * @see \Aedart\Overload\Traits\SetterInvokerTrait
 * @see \Aedart\Overload\Traits\IssetInvokerTrait
 * @see \Aedart\Overload\Traits\UnsetInvokerTrait
 * @see \Aedart\Overload\Traits\Helper\PropertyAccessibilityTrait
 *
 * @author Alin Eugen Deac <aedart@gmail.com>
 */
trait PropertyOverloadTrait
{
    use ReflectionTrait;
    use GetterInvokerTrait;
    use SetterInvokerTrait;
    use IssetInvokerTrait;
    use UnsetInvokerTrait;
}
