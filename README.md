# DTO Generator

PHP library for generating DTO classes.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install micro/dto.

```bash
composer require micro/dto
```

## Usage

#### Declare all required classes in the XML Schemes

* example.xml
* See the full list of possible options in the [XSD scheme](src/Resource/schema/dto-01.xsd)

``` xml
<?xml version="1.0"?>
<dto xmlns="micro:dto-01"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="micro:dto-01 https://raw.githubusercontent.com/Micro-PHP/dto/master/src/Resource/schema/dto-01.xsd">
    <class name="User\User">
        <property name="email" type="string"/>
        <property name="age" type="int"/>
        <property name="parent" type="User\User" /> 
    </class>
</dto>
```
 * And run generator
```php
use Micro\Library\DTO\ClassGeneratorFacadeDefault;

$classGenerator = new ClassGeneratorFacadeDefault(
    ['./example.xml'],    // List of class declaration files
    './out',              // Path to the folder where to generate 
    'Transfer'            // Suffix for the all DTO classes (optional)
);

$classGenerator->generate();

```

 * Example usages

```php

// Create new User object
$user = new User();

//Restore User object from array
$user = new UserTransfer([
   'email'   => 'stas@micro.org',
   'age'     => 32,
   'parent'  => [
       'email'  => 'papa@micro.org',
       'age'    => 53,
   ]
]);

$user->getParent()->getEmail(); // papa@micro.org
// OR
$user['parent']['email']; // papa@micro.org


$user->setAge(33);
//OR
$user['age'] = 33;

// Serialize to JSON
$json = json_encode($user);

// Iterate as array
foreach ($user as $property => $value) {
    doSomethind();
}
```



## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)