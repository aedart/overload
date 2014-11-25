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

composer require aedart/overload dev-master
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

```

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

**Examples:**

```
#!php
<?php

$personId = 78; // Will look for getPersonId() and setPersonId($value);

$category_name = 'Products' // Will look for getCategoryName() and setCategoryName($value);

```

## License ##

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package