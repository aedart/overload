[![Build Status](https://travis-ci.org/aedart/overload.svg?branch=master)](https://travis-ci.org/aedart/overload)
[![Latest Stable Version](https://poser.pugx.org/aedart/overload/v/stable)](https://packagist.org/packages/aedart/overload)
[![Total Downloads](https://poser.pugx.org/aedart/overload/downloads)](https://packagist.org/packages/aedart/overload)
[![Latest Unstable Version](https://poser.pugx.org/aedart/overload/v/unstable)](https://packagist.org/packages/aedart/overload)
[![License](https://poser.pugx.org/aedart/overload/license)](https://packagist.org/packages/aedart/overload)

# Deprecated - Overload

Package has been replaced by [aedart/athenaeum](https://github.com/aedart/athenaeum)

Provides means to dynamically deal with inaccessible properties, by implementing PHP's magic methods;
`__get()`, `__set()`, `__isset()`, and `__unset()`. This package, however, enforces the usage of getters- and setters-methods, ensuring that if a property
is indeed available, then its corresponding getter or setter method will be invoked. The term 'overload', in this context, refers to PHP’s own definition hereof. (http://php.net/manual/en/language.oop5.overloading.php)

## Contents

  * [When to use this](#when-to-use-this)
  * [How to install](#how-to-install)
  * [Quick start](#quick-start)
    + [A Typical Class](#a-typical-class)
    + [Tip: PHPDoc](#tip--phpdoc)
  * [Naming convention applied](#naming-convention-applied)
    + [Property names](#property-names)
    + [Getter / Setter names](#getter---setter-names)
  * [Protected vs. Private properties](#protected-vs-private-properties)
    + [Behaviour override](#behaviour-override)
  * [Custom usage](#custom-usage)
  * [Contribution](#contribution)
    + [Bug Report](#bug-report)
    + [Fork, code and send pull-request](#fork--code-and-send-pull-request)
  * [Versioning](#versioning)
  * [License](#license)

## When to use this

Generally speaking, magic methods can be very troublesome to use. For the most part, they prohibit the usage of auto-completion in IDEs and if not documented, developers are forced to read large sections of the source code, in order to gain understanding of what’s going on. Depending upon implementation, there might not be any validation, when dynamically assigning new properties to objects, which can break other components, which depend on the given object. In addition to this, it can also be very difficult to write tests for components that are using such magic methods.

This package will not be able to solve any of the mentioned problems, because at the end of the day, as a developer, you still have to ensure that the code readable / understandable, testable and documented. Therefore, I recommend that this package only to be used, if and only if, the following are all true;

-	Properties shouldn't be allowed to be dynamically created and assigned to an object, without prior knowledge about them. Thus, properties must always be predefined.
-	Getters and setters must always be used for reading / writing properties
-	You wish to allow access to an object’s properties like such: `$person->age;` and still enforce some kind of validation.

## How to install

```console

composer require aedart/overload
```

This package uses [composer](https://getcomposer.org/). If you do not know what that is or how it works, I recommend that you read a little about, before attempting to use this package.

## Quick start

### A Typical Class

```php
<?php

use Aedart\Overload\Traits\PropertyOverloadTrait;

/**
 * @property string $name Name of a person
 */
class Person
{
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
    public function getName() : string
    {
	    return $this->name;
    }

    // A setter method $name
    public function setName(string $value)
    {
        if( ! empty($value)){
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

### Tip: PHPDoc

When using PHP’s magic methods, for overloading properties, it is a very good idea to make use pf PHPDoc's `@property`-tag.
Most IDEs can read it and make use of it to provide auto-completion.
See http://www.phpdoc.org/docs/latest/references/phpdoc/tags/property.html

## Naming convention applied

### Property names

This package assumes that you properties either follow [CamelCase](http://en.wikipedia.org/wiki/CamelCase) or [Snake Case](http://en.wikipedia.org/wiki/Snake_case) standard. Consider the following examples:

```php
<?php

$personId = 78; // Valid

$category_name = 'Products'; // Valid

$swordFish_length = 63; // Invalid, because its a mix of both camelCase and underscore
```

### Getter / Setter names

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

```php
<?php

$personId = 78; // Will look for getPersonId() and setPersonId($value);

$category_name = 'Products'; // Will look for getCategoryName() and setCategoryName($value);
```

## Protected vs. Private properties

By default, only `protected` properties are going to be made accessible (or overloaded, if you will). This means that `private` declared properties are not going to be available.

```php
<?php

use Aedart\Overload\Traits\PropertyOverloadTrait;

class Person
{
    use PropertyOverloadTrait;

    protected $name = null; // This is made accessible, because of the PropertyOverloadTrait.
			    // When attempted to read, getName() is invoked
			    // When attempted to write, setName($value) is invoked

    private $age = null; // Is NOT made accessible, read / write attempts will result in Exception

    // Remaining implementation not shown...
}
```

### Behaviour override

Should you wish to also expose your private declared properties, then this behaviour can be set per object, from an inside scope.

```php
<?php

use Aedart\Overload\Interfaces\PropertyAccessibilityLevel;
use Aedart\Overload\Traits\PropertyOverloadTrait;

class Person
{
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

## Custom usage

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

## Contribution

Have you found a defect ( [bug or design flaw](https://en.wikipedia.org/wiki/Software_bug) ), or do you wish improvements? In the following sections, you might find some useful information
on how you can help this project. In any case, I thank you for taking the time to help me improve this project's deliverables and overall quality.

### Bug Report

If you are convinced that you have found a bug, then at the very least you should create a new issue. In that given issue, you should as a minimum describe the following;

* Where is the defect located
* A good, short and precise description of the defect (Why is it a defect)
* How to replicate the defect
* (_A possible solution for how to resolve the defect_)

When time permits it, I will review your issue and take action upon it.

### Fork, code and send pull-request

A good and well written bug report can help me a lot. Nevertheless, if you can or wish to resolve the defect by yourself, here is how you can do so;

* Fork this project
* Create a new local development branch for the given defect-fix
* Write your code / changes
* Create executable test-cases (prove that your changes are solid!)
* Commit and push your changes to your fork-repository
* Send a pull-request with your changes
* _Drink a [Beer](https://en.wikipedia.org/wiki/Beer) - you earned it_ :)

As soon as I receive the pull-request (_and have time for it_), I will review your changes and merge them into this project. If not, I will inform you why I choose not to.

## Versioning

This package follows [Semantic Versioning 2.0.0](http://semver.org/)

## License

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package
