<?php

declare(strict_types=1);

require dirname(__FILE__) . '/../vendor/autoload.php';

$classGenerator = new \Micro\Library\DTO\ClassGeneratorFacadeDefault(
    ['./example.xml'],
    './out',
    'Transfer',
    'Transfer',
);

$classGenerator->generate();

require_once 'out/Simple/SimpleObjectTransfer.php';
require_once 'out/Simple/SimpleUserTransfer.php';
require_once 'out/UserTransfer.php';


$simpleObject = new \Transfer\Simple\SimpleObjectTransfer();
$simpleObject
    ->setWeight(9)
    ->setHeight(8);

$simpleUser = new \Transfer\Simple\SimpleUserTransfer();
$simpleUser
    ->setParent($simpleObject)
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

$validator = new \Micro\Library\DTO\ValidatorFacadeDefault();
dump($validator->validate($simpleUser));

$simpleUser->setChoice([1, 'example']);

dump($validator->validate($simpleUser, 'multiple'));