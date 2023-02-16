<?php

declare(strict_types=1);

/*
 *  This file is part of the Micro framework package.
 *
 *  (c) Stanislau Komar <kost@micro-php.net>
 *
 *  For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 */

namespace Micro\Library\DTO\Tests\Unit;

use Micro\Library\DTO\ClassGeneratorFacadeDefault;
use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\SerializerFacadeDefault;
use Micro\Library\DTO\Tests\Unit\Out\Simple\SimpleObjectTransfer;
use Micro\Library\DTO\Tests\Unit\Out\Simple\SimpleUserTransfer;
use Micro\Library\DTO\ValidatorFacadeDefault;
use PHPUnit\Framework\TestCase;

class libraryTest extends TestCase
{
    public function testLibrary(): void
    {
        $this->generateClasses('example');
        $this->assertTrue(true);
    }

    public function testPropertyTypeDuplicated(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage('Class "Micro\Library\DTO\Tests\Unit\Out\UserTransfer" property "username": Invalid type "string|string"');
        $this->generateClasses('invalid_prop_type_duplicate');
    }

    public function testInvalidSchema(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->generateClasses('invalid_schema');
    }

    public function testPropertyinvalidType(): void
    {
        $this->expectExceptionMessage('Class "Micro\Library\DTO\Tests\Unit\Out\UserTransfer" property "username": Invalid type "string|mixed"');
        $this->expectException(\RuntimeException::class);
        $this->generateClasses('invalid_prop_type');
    }

    public function testUniqueProperty(): void
    {
        $this->expectExceptionMessage('Property "username" already declared in User');
        $this->expectException(\RuntimeException::class);
        $this->generateClasses('invalid_unique_prop');
    }

    public function testSchemaFileNotFount(): void
    {
        $this->expectException(\RuntimeException::class);
        $this->generateClasses('file_not');
    }

    public function testValidateSuccessDto(): void
    {
        $validatorFacade = new ValidatorFacadeDefault();

        $this->assertEquals(0, \count($validatorFacade->validate($this->createValidDto())));
    }

    public function testValidateEmptyDto(): void
    {
        $validatorFacade = new ValidatorFacadeDefault();

        $this->assertEquals(12, \count($validatorFacade->validate($this->createEmptyDto())));
    }

    public function testSerializeEmpty(): void
    {
        $empty = $this->createEmptyDto();
        $json = '{"parent":null,"username":null,"age":null,"email":null,"ip":null,"hostname":null,"sometext":null,"url":null,"json":null,"uuid":null,"created_at":null,"updated_at":null,"time":null,"timezone":null,"card_scheme":null,"bic":null,"currency":null,"iban":null,"isbn":null,"issn":null,"isin":null}';

        $this->testSerialize($empty, $json);
    }

    public function testSerializeValid(): void
    {
        $json = '{"parent":{"weight":9,"height":8,"parent":null},"username":"Asisyas","age":19,"email":"test@example.com","ip":"192.168.0.1","hostname":"localhost","sometext":"azds","url":"\/\/abc","json":"{\"test\": 123}","uuid":"ffd4ff99-33ed-4a13-88cf-47e22de29dcc","created_at":"2002-08-11 20:08:01","updated_at":"2002-08-11","time":"14:04:01","timezone":"Europe\/Minsk","card_scheme":"5555555555554444","bic":"MIDLGB22","currency":"USD","iban":"BY 13 NBRB 3600900000002Z00AB00","isbn":"978-0-545-01022-1","issn":"0378-5955","isin":"US0378331005"}';
        $this->testSerialize($this->createValidDto(), $json);
    }

    public function testIterableDto(): void
    {
        $simpleUser = new SimpleUserTransfer();
        $keys = [];
        foreach ($simpleUser as $key => $value) {
            $keys[] = $key;
        }

        $this->assertEquals(21, \count($keys));

        $simpleUser['username'] = 'test';
        $this->assertEquals('test', $simpleUser['username']);
        unset($simpleUser['username']);
        $this->assertNull($simpleUser['username']);

        $invalidProperty = 'prop_no_exists';
        $this->assertFalse(isset($simpleUser[$invalidProperty]));

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(sprintf('Property "%s" is not declared in the class "%s".', $invalidProperty, SimpleUserTransfer::class));
        $simpleUser[$invalidProperty];
    }

    protected function testSerialize(AbstractDto $dtoTransfer, string $exceptedJson): void
    {
        $serializer = new SerializerFacadeDefault();

        $json = $serializer->toJsonTransfer($dtoTransfer);
        $arrayTransfer = $serializer->toArrayTransfer($dtoTransfer);

        $this->assertEquals($dtoTransfer, $serializer->fromArrayTransfer($arrayTransfer));

        $simpleJson = $serializer->toJson($dtoTransfer);
        $this->assertEquals($exceptedJson, $simpleJson);

        $this->assertEquals($dtoTransfer, $serializer->fromJsonTransfer($json));
    }

    protected function createEmptyDto(): SimpleUserTransfer
    {
        return new SimpleUserTransfer();
    }

    protected function createValidDto(): SimpleUserTransfer
    {
        $simpleUserParent = new SimpleObjectTransfer();
        $simpleUserParent
            ->setWeight(9)
            ->setHeight(8);

        $simpleUser = new SimpleUserTransfer();

        return $simpleUser
            ->setParent($simpleUserParent)
            ->setIp('192.168.0.1')
            ->setAge(19)
            ->setEmail('test@example.com')
            ->setHostname('localhost')
            ->setUsername('Asisyas')
            ->setSometext('azds')
            ->setTime('14:04:01')
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
        ;
    }

    protected function generateClasses(string $schemaName): void
    {
        $classGenerator = new ClassGeneratorFacadeDefault(
            [__DIR__.'/'.$schemaName.'.xml'],    // List of class declaration files
            __DIR__.'/Out',              // Path to the folder where to generate
            'Micro\Library\DTO\Tests\Unit\Out'            // Suffix for the all DTO classes (optional)
        );
        $classGenerator->generate();
    }
}
