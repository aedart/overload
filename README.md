## Overload ##

Provides means to dynamically deal with inaccessible properties, by implementing PHP’s magic methods;
`__get()`, `__set()`, `__isset()`, and `__unset()`. This package, however, enforces the usage of getters- and setters-methods, ensuring that if a property
is indeed available, then its corresponding getter or setter method will be invoked. The term 'overload', in this context, refers to PHP’s own definition hereof. (http://php.net/manual/en/language.oop5.overloading.php)

Official project website (https://bitbucket.org/aedart/overload)

## Contents ##

[TOC]

## How to install ##

```
composer require aedart/overload dev-master
```

This package uses [composer](https://getcomposer.org/). If you do not know what that is or how it works, I recommend that you read a little about, before attempting to use this package.

## Quick start ##

### A Person class ###

```
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

## License ##

[BSD-3-Clause](http://spdx.org/licenses/BSD-3-Clause), Read the LICENSE file included in this package