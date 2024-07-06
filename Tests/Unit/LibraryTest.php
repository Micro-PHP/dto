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
use Micro\Library\DTO\Tests\Simple\SimpleObjectTransfer;
use Micro\Library\DTO\Tests\Simple\SimpleUserTransfer;
use Micro\Library\DTO\ValidatorFacadeDefault;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
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

        $this->assertEquals(14, \count($validatorFacade->validate($this->createEmptyDto())));
    }

    public function testSerializeEmpty(): void
    {
        $empty = $this->createEmptyDto();
        $json = file_get_contents(__DIR__.'/json_empty.json');

        $this->serializeTest($empty, $json);
    }

    public function testSerializeValid(): void
    {
        $json = file_get_contents(__DIR__.'/json_valid.json');
        $this->serializeTest($this->createValidDto(), $json);
    }

    public function testIterableDto(): void
    {
        $simpleUser = new SimpleUserTransfer();
        $keys = [];
        foreach ($simpleUser as $key => $value) {
            $keys[] = $key;
        }

        $this->assertEquals(23, \count($keys));

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

    private function serializeTest(AbstractDto $dtoTransfer, string $exceptedJson): void
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
            ->setChoice('example')
            ->setExpression('example')
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
