<?php

require dirname(__FILE__) . '/../vendor/autoload.php';

// Create Logger
$logger = new class extends \Psr\Log\NullLogger {
    public function debug(\Stringable|string $message, array $context = []): void
    {
        print_r("$message\r\n");
    }
};

// Create default class generator facade
$classGenerator = new \Micro\Library\DTO\ClassGeneratorFacadeDefault(
    ['./example.xml'],
    './out',
    'Transfer',
    'Transfer',
    $logger
);

$classGenerator->generate();

// Require generated classes
require_once 'out/Simple/SimpleObjectTransfer.php';
require_once 'out/Simple/SimpleUserTransfer.php';
require_once 'out/UserTransfer.php';


$user = new \Transfer\UserTransfer();
$user
    ->setFirstName('Stas')
    ->setUsername('Asisyas')
    ->setUpdatedAt(new DateTime('11.08.1989'))
    ->setBooks(
        [
            (new Transfer\Simple\SimpleObjectTransfer())
                ->setHeight(1)
                ->setWeight(20)
                ->setParent(
                    (new Transfer\Simple\SimpleObjectTransfer())
                        ->setHeight(100)
                        ->setWeight(2000)
                )
        ])
    ->setSomeclass(
        (new \Transfer\Simple\SimpleObjectTransfer())
            ->setWeight(1)
            ->setHeight(2)
    )
;

// Iterate as array
foreach ($user as $key => $value) {
//    print_r("\r\nPROPERTY: " . $key . " ==== " . (is_scalar($value) ? $value : serialize($value)));
}

//
//print_r('FISRT BOOK HEIGHT : ' . $user['books'][0]['height'] . "\r\n");
//print_r('FISRT BOOK PARENT HEIGHT : ' . $user['books'][0]['parent']['height'] . "\r\n");


$classSerializerFacade = new \Micro\Library\DTO\SerializerFacadeDefault();


$json = $classSerializerFacade->toJsonTransfer($user);

//dump($json);

$result = $classSerializerFacade->fromJsonTransfer($json);

$mf = new \Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory(new \Symfony\Component\Validator\Mapping\Loader\AnnotationLoader());

$vb = \Symfony\Component\Validator\Validation::createValidatorBuilder();
$vb->setMetadataFactory($mf);
$vb->disableAnnotationMapping();
$validator = $vb->getValidator();

$simpleUserParent = new \Transfer\Simple\SimpleObjectTransfer();
$simpleUserParent
    ->setWeight(9)
    ->setHeight(8);

$simpleUser = new \Transfer\Simple\SimpleUserTransfer();
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
;

$constraints = $validator->validate($simpleUser);

dump($constraints);

//dump($result);


