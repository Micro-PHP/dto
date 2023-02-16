# DTO Generator

PHP library for generating DTO classes.

## Installation

Use the package manager [composer](https://getcomposer.org/) to install micro/dto.

```bash
composer require micro/dto
```

## Usage

#### Declare all required classes in the XML Schemea

* example.xml
* See the full list of possible options in the [XSD schema](src/Resource/schema/dto-1.6.xsd)

``` xml
<?xml version="1.0"?>
<dto xmlns="micro:dto-1.6"
     xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
     xsi:schemaLocation="micro:dto-1.6 https://raw.githubusercontent.com/Micro-PHP/dto/master/src/Resource/schema/dto-1.6.xsd">
    <class name="User\User">
        <property name="email" type="string">
            <validation>
                <not_blank/>
                <email/>
            </validation>
        </property>
        <property name="username" type="string">
          <validation>
               <length min="6" max="50"/>
               <regex pattern="/^(.[aA-zA]+)$/"/>
          </validation>
        </property>
        <property name="age" type="int">
            <validation>
                <not_blank groups="put"/>
                <greater_than value="18" />
                <less_than value="100" groups="put, patch" />
            </validation>
        </property>
        <property name="updatedAt" type="datetime" />
        <property name="parent" type="User\User" /> 
    </class>
</dto>
```
 * And run generator
```php
$classGenerator = new \Micro\Library\DTO\ClassGeneratorFacadeDefault(
    ['./example.xml'],    // List of class declaration files
    './out',              // Path to the folder where to generate 
    'Transfer'            // Suffix for the all DTO classes (optional)
);
$classGenerator->generate();

// Usage example
$user = new \User\UserTransfer();
$user
    ->setAge(19)
    ->setEmail('demo@micro-php.net');
// OR
//
$user['age'] = 19;
$user['email'] = 'demo@micro-php.net';

// Validation example
$validator = new \Micro\Library\DTO\ValidatorFacadeDefault(); 
$validator->validate($user); // Validation groups by default ["Default"]   
$validator->validate($user, ['patch', 'put']); // Set validation groups ["patch", "put"]

// Serialize example
$serializer = new \Micro\Library\DTO\SerializerFacadeDefault();
$serializer->toArray($user); // Simple array
$serializer->toJson($user); // Simple Json

// Deserialize example
$serialized = $serializer->toJsonTransfer($user);
$deserialized = $serializer->fromJsonTransfer($serialized);

```

### [See full example](./example/)


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

## License
[MIT](https://choosealicense.com/licenses/mit/)
