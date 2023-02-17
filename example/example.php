<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

/**
 *  Create default class generator facade
 */
$classGenerator = new \Micro\Library\DTO\ClassGeneratorFacadeDefault(
    ['./example.xml'],
    './out',
    'Transfer',
    'Transfer',
);

$classGenerator->generate();

/**
 * Require generated classes
 */
require_once 'out/Simple/SimpleObjectTransfer.php';
require_once 'out/Simple/SimpleUserTransfer.php';
require_once 'out/UserTransfer.php';

use Transfer\UserTransfer;
use Transfer\Simple\SimpleObjectTransfer;
use Micro\Library\DTO\SerializerFacadeDefault;
use Micro\Library\DTO\ValidatorFacadeDefault;
use Transfer\Simple\SimpleUserTransfer;

/**
 * Iterate DTO values
 */
$user = new UserTransfer();
$user
    ->setFirstName('Stas')
    ->setUsername('Asisyas')
    ->setUpdatedAt(new DateTime('11.08.1989'))
    ->setBooks(
        [
            (new SimpleObjectTransfer())
                ->setHeight(1)
                ->setWeight(20)
                ->setParent(
                    (new SimpleObjectTransfer())
                        ->setHeight(100)
                        ->setWeight(2000)
                )
        ])
    ->setSomeclass(
        (new SimpleObjectTransfer())
            ->setWeight(1)
            ->setHeight(2)
    )
;

foreach ($user as $key => $value) {
    print_r("\r\nPROPERTY: " . $key . " ==== " . (is_scalar($value) ? $value : (is_null($value) ? 'NULL' : serialize($value))));
}


/**
 * Array access example
 */
print_r("\r\n\r\nFISRT BOOK HEIGHT : " . $user['books'][0]['height'] . "\r\n");
print_r('FISRT BOOK PARENT HEIGHT : ' . $user['books'][0]['parent']['height'] . "\r\n\r\n");
// Allowed too
$user['books'][0]['height'] = 12;

/**
 * Serialization example
 */
$classSerializerFacade = new SerializerFacadeDefault();
$jsonDto = $classSerializerFacade->toJsonTransfer($user);
$json = $classSerializerFacade->toJson($user);

print_r('Serialized DTO: ' . $jsonDto . "\r\n\r\n");
print_r('Serialize DTO as JSON: ' . $json . "\r\n\r\n");

$deserialized = $classSerializerFacade->fromJsonTransfer($jsonDto);

$className = get_class($user);
$okNo = get_class($deserialized) === $className ?'true' : 'false';
print_r( "Deserialize $className: $okNo \r\n");

/**
 * Validate DTO example
 */
$simpleUserParent = new SimpleObjectTransfer();
$simpleUserParent
    ->setWeight(9)
    ->setHeight(8);

$simpleUser = new SimpleUserTransfer();
$simpleUser
    ->setParent($simpleUserParent)
    ->setIp('192.168.0.1')
    ->setAge(19)
    ->setEmail('test@example.com')
    ->setHostname('localhost')
    ->setUsername('Asisyas')
    ->setSometext('azds')
    ->setUrl('//abc')
    ->setJson('{"test": 123}')
    ->setUuid('ffd4ff99-33ed-4a13-88cf-47e22de29dcc')
    ->setCreatedAt('2002-08-11 20:08:01')
    ->setUpdatedAt('2002-08-11')
    ->setTimezone('Europe/Minsk')
    ->setCardScheme('5555555555554444')
    ->setBic('MIDLGB22')
    ->setCurrency('USD')
    ->setIban('BY 13 NBRB 3600900000002Z00AB00')
    ->setIsbn('978-0-545-01022-1')
    ->setIssn('0378-5955')
    ->setIsin('US0378331005')
    ->setChoice('example')
;

$validator = new ValidatorFacadeDefault();
$constraints = $validator->validate($simpleUser);

$validationStatus = !count($constraints) ? 'Validated': 'Validation error';

print_r("Validation status: $validationStatus\r\n");

