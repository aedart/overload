## Overload ##

Provides means to dynamically deal with inaccessible properties, by implementing PHP’s magic methods;
`__get()`, `__set()`, `__isset()`, and `__unset()`. This package, however, enforces the usage of getters- and setters-methods, ensuring that if a property
is indeed available, then its corresponding getter or setter method will be invoked. The term 'overload', in this context, refers to PHP’s own definition hereof. (http://php.net/manual/en/language.oop5.overloading.php)

Official project website (https://bitbucket.org/aedart/overload)

## Contents ##

[TOC]

## When to use this ##

Generally speaking, magic methods can be very troublesome to use. For the most part, they prohibit the usage of auto-completion in IDEs and if not documented, developers are forced to read large sections of the source code, in order to gain understanding of what’s going on. Depending upon implementation, there might not be any validation, when dynamically assigning new properties to objects, which can break other components, which depend on the given object. In addition to this, it can also be very difficult to write tests for components that are using such magic methods.

This package will not be able to solve any of the mentioned problems, because at the end of the day, as a developer, you still have to ensure that the code readable / understandable, testable and documented. Therefore, I recommend that this package only to be used, if and only if, the following are all true;

-	Properties shouldn’t be allowed to be dynamically created and assigned to an object, without prior knowledge about them. Thus, properties must always be predefined.
-	Getters and setters must always be used for reading / writing properties
-	You wish to allow access to an object’s properties like such: `$person->age;` and still enforce some kind of validation.

## How to install ##

```
#!console

composer require aedart/overload 1.*
```

This package uses [composer](https://getcomposer.org/). If you do not know what that is or how it works, I recommend that you read a little about, before attempting to use this package.

## Quick start ##

### A Person class ###

```
#!php
<?php

use Aedart\Overload\Interfaces\PropertyOverloadable;
use Aedart\Overload\Traits\PropertyOverloadTrait;

/**
 * @property string $name Name of a person
 */
class Person implements PropertyOverloadable{
    
    use PropertyOverloadTrait;
    
    /**
     * Name of a person
     * 
     * @var string|null
     */
    protected $name = null; // This is made accessible, because of the PropertyOverloadTrait.
			    // When attempted to read, getName() is invoked
			    // When attempted to write, setName($value) is invoked
    
    
    // A getter method for $name
    public function getName(){
	return $this->name;
    }

    // A setter method $name
    public function setName($value){
	if(is_string($value) && !empty($value)){
	    $this->name = $value;
	    return;
	}
	
	throw new InvalidArgumentException('Provided name is invalid');
    }
}

// Some place else, in your application, you can then invoke the following:
$person = new Person();
$person->name = 'Alin'; // Invokes the setName(...)
echo $person->name;	// Invokes the getName(), then outputs 'Alin'
echo isset($person->name); // Invokes the __isset(), then outputs true
unset($person->name); // Invokes the __unset() and destroys the name property

```

### Tip: PHPDoc ###

When using PHP’s magic methods, for overloading properties, it is a very good idea to make use pf PHPDoc's `@property`-tag.
Most IDEs can read it and make use of it to provide auto-completion.
See http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html

## Naming convention applied ##

### Property names ###

This package assumes that you properties either follow [camelCase](http://en.wikipedia.org/wiki/Naming_convention_%28programming%29#Letter_case_and_numerals) or [underscore](http://en.wikipedia.org/wiki/Naming_convention_%28programming%29#Letter_case_and_numerals) standard. Consider the following examples:

```
#!php
<?php

$personId = 78; // Valid

$category_name = 'Products' // Valid

$swordFish_length = 63; // Invalid, because its a mix of both camelCase and underscore

```

### Getter / Setter names ###

Getters and setters follow a most strict naming convention; the must follow camelCase and be prefixed with `get` for getter methods and `set` for setter methods. In addition, the package uses the following syntax / rule when searching for a property’s corresponding getter or setter:

```
getterMethod = getPrefix, camelCasePropertyName;
getPrefix = "get";

setterMethod = setPrefix, camelCasePropertyName;
setPrefix = "set";

camelCasePropertyName = {uppercaseLetter, {lowercaseLetter}};
uppercaseLetter = "A" | "B" | "C" | "D" | "E" | "F" | "G" | "H" | "I" | "J" | "K"
| "L" | "M" | "N" | "O" | "P" | "Q" | "R" | "S" | "T" | "U" | "V" | "W" | "X"
| "Y" | "Z" ;
lowercaseLetter = "a" | "b" | "c" | "d" | "e" | "f" | "g" | "h" | "i" | "j" | "k"
| "l" | "m" | "n" | "o" | "p" | "q" | "r" | "s" | "t" | "u" | "v" | "w" | "x"
| "y" | "z" ;
```

Above stated syntax / rule is expressed in [EBFN](http://en.wikipedia.org/wiki/Extended_Backus%E2%80%93Naur_Form)

**Examples:**

```
#!php
<?php

$personId = 78; // Will look for getPersonId() and setPersonId($value);

$category_name = 'Products' // Will look for getCategoryName() and setCategoryName($value);

```

## Protected vs. Private properties ##

By default, only `protected` properties are going to be made accessible (or overloaded, if you will). This means that `private` declared properties are not going to be available.

```
#!php
<?php

use Aedart\Overload\Interfaces\PropertyOverloadable;
use Aedart\Overload\Traits\PropertyOverloadTrait;

class Person implements PropertyOverloadable{

    use PropertyOverloadTrait;

    protected $name = null; // This is made accessible, because of the PropertyOverloadTrait.
			    // When attempted to read, getName() is invoked
			    // When attempted to write, setName($value) is invoked

    private $age = null; // Is NOT made accessible, read / write attempts will result in Exception

    // Remaining implementation not shown...
}

```

### Behaviour override ###

Should you wish to also expose your private declared properties, then this behaviour can be set per object, from an inside scope.

```
#!php
<?php

use Aedart\Overload\Interfaces\PropertyOverloadable;
use Aedart\Overload\Interfaces\PropertyAccessibilityLevel;
use Aedart\Overload\Traits\PropertyOverloadTrait;

class Person implements PropertyOverloadable{

    use PropertyOverloadTrait;

    protected $name = null; // This is made accessible, because of the PropertyOverloadTrait.
			    // When attempted to read, getName() is invoked
			    // When attempted to write, setName($value) is invoked

    private $age = null;    // This is made accessible, because of the $this->setPropertyAccessibilityLevel(...).
			    // When attempted to read, getName() is invoked
			    // When attempted to write, setName($value) is invoked

    public function __construct(){
	// Change the property accessibility to private
	$this->setPropertyAccessibilityLevel(PropertyAccessibilityLevel::PRIVATE_LEVEL);
    }
}

```

For further reference, read documentation in `Overload/Traits/Helper/PropertyAccessibilityTrait`

## Custom usage ##

If you do not need the full property overload methods, e.g. you only wish to be able to get and set, but not to unset properties, then you can make use of the sub-traits, which the `PropertyOverloadTrait` is composed of.

However, when using individually, you must also include the `Aedart\Overload\Traits\Helper\ReflectionTrait` or the individual traits are not going to work as expected; A fatal error will be thrown, stating that it cannot find various methods!

Each of the below listed traits can be used by themselves, without being dependent on each other.

Trait  | Description | Namespace
------------- | ------------- | -------------
ReflectionTrait | *Must always be included* | Aedart\Overload\Traits\Helper\ReflectionTrait
GetterInvokerTrait | Implements `__get()` | Aedart\Overload\Traits\GetterInvokerTrait
SetterInvokerTrait  | Implements `__set()` | Aedart\Overload\Traits\SetterInvokerTrait
IssetInvokerTrait  | Implements `__isset()` | Aedart\Overload\Traits\IssetInvokerTrait
UnsetInvokerTrait  | Implements `__unset()` | Aedart\Overload\Traits\UnsetInvokerTrait

## License ##

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package