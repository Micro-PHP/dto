# DTO Generator

PHP library for generating DTO classes.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install micro/dto.

```bash
composer require micro/dto
```

## Usage

#### Create DTO Chema

* example.xml

``` xml
<?xml version="1.0"?>
<dto xmlns="micro:dto-01"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="micro:dto-01 src/Resource/schema/dto-01.xsd">
    <class name="User\User">
        <property name="email" type="string"/>
        <property name="age" type="int"/>
        <property name="parent" type="User\User" /> 
    </class>
</dto>
```

```php
$classGenerator = new \Micro\Library\DTO\ClassGeneratorFacadeDefault(
    ['./example.xml'],    // List of class declaration files
    './out',              // Path to the folder where to generate 
    'Transfer'            // Suffix (optional)
);

$classGenerator->generate();

```

```php


//Restore User object from array
$user = new UserTransfer([
   'email'   => 'stas@micro.org',
   'age'     => 32,
   'parent'  => [
       'email'  => 'papa@micro.org',
       'age'    => 53,
   ]
]);

// Create new User object
$user2 = new User();

```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://choosealicense.com/licenses/mit/)