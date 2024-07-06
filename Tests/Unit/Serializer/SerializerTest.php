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

namespace Micro\Library\DTO\Tests\Unit\Serializer;

use Micro\Library\DTO\Exception\SerializeException;
use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Object\Collection;
use Micro\Library\DTO\Serializer\Serializer;
use Micro\Library\DTO\Serializer\SerializerInterface;
use Micro\Library\DTO\Tests\Simple\SimpleObjectTransfer;
use PHPUnit\Framework\TestCase;
use Micro\Library\DTO\Tests\Simple\UserTransfer;

class SerializerTest extends TestCase
{
    public function testToArray(): void
    {
        $dto = $this->createDtoForTest();
        $exceptedArray = $this->getExceptedDtoJson();
        $actualArrayTmp = $this->createSerializer()->toArray($dto);
        $actualArray = json_encode($actualArrayTmp);

        $this->assertEquals($exceptedArray, $actualArray);
    }

    public function testFromArrayTransfer(): void
    {
        $dto = $this->createDtoForTest();
        $dtoArray = $this->createSerializer()->toArrayTransfer($dto);
        $actualDto = $this->createSerializer()->fromArrayTransfer($dtoArray);

        $this->assertInstanceOf(AbstractDto::class, $actualDto);

        $this->assertTrue($this->compareDto($dto, $actualDto));
    }

    public function testFromJsonTransfer(): void
    {
        $dtoActual = $this->createDtoForTest();
        $json = $this->createSerializer()->toJsonTransfer($dtoActual);
        $dtoUnserialized = $this->createSerializer()->fromJsonTransfer($json);

        $this->assertInstanceOf(AbstractDto::class, $dtoUnserialized);
    }

    public function testToArrayTransfer(): void
    {
        $actual = $this->createSerializer()->toArray($this->createDtoForTest());

        $this->assertIsArray($actual);
    }

    public function testToJsonTransfer(): void
    {
        $actual = $this->createSerializer()->toJsonTransfer($this->createDtoForTest());

        $result = json_decode($actual, true);

        $this->assertIsArray($result);
    }

    /**
     * @throws SerializeException
     */
    public function testToJson(): void
    {
        $dto = $this->createDtoForTest();
        $serialized = $this->createSerializer()->toJson($dto);
        $exceptedJson = $this->getExceptedDtoJson();

        $this->assertEquals($exceptedJson, $serialized);
    }

    protected function compareDto(AbstractDto $excepted, AbstractDto $actual): bool
    {
        foreach ($excepted as $keyExcept => $valueExcept) {
            $valueActual = $actual[$keyExcept];
            if ($valueActual instanceof Collection) {
                foreach ($valueActual as $key => $collItem) {
                    if ($collItem instanceof AbstractDto) {
                        if (!$this->compareDto($collItem, $valueExcept[$key])) {
                            return false;
                        }
                    }
                }

                continue;
            }

            if ($valueExcept instanceof \DateTimeInterface) {
                $diff = $valueExcept->diff($valueActual);
                $result = sprintf(
                    '%d%d%d%d%d%d%f',
                    $diff->y,
                    $diff->m,
                    $diff->d,
                    $diff->h,
                    $diff->i,
                    $diff->s,
                    $diff->f
                );
                if ('0000000.000000' !== $result) {
                    return false;
                }

                continue;
            }

            if ($valueExcept instanceof AbstractDto) {
                if (!$this->compareDto($valueExcept, $valueActual)) {
                    return false;
                }

                continue;
            }

            if ($valueActual !== $valueExcept) {
                return false;
            }
        }

        return true;
    }

    protected function createSerializer(): SerializerInterface
    {
        return new Serializer();
    }

    protected function getExceptedDtoJson(): string
    {
        return '{"username":"Asisyas","books":[{"weight":20,"height":1,"parent":{"weight":2000,"height":100,"parent":null}}],"first_name":"Stas","updatedAt":{"date":"1989-08-11 00:00:00.000000","timezone_type":3,"timezone":"UTC"},"someclass":{"weight":1,"height":2,"parent":null},"testMixed":null}';
    }

    protected function createDtoForTest(): UserTransfer
    {
        $user = new UserTransfer();
        $user
            ->setFirstName('Stas')
            ->setUsername('Asisyas')
            ->setUpdatedAt(new \DateTime('11.08.1989'))
            ->setBooks(
                [
                    (new SimpleObjectTransfer())
                        ->setHeight(1)
                        ->setWeight(20)
                        ->setParent(
                            (new SimpleObjectTransfer())
                                ->setHeight(100)
                                ->setWeight(2000)
                        ),
                ]
            )
            ->setSomeclass(
                (new SimpleObjectTransfer())
                    ->setWeight(1)
                    ->setHeight(2)
            )
        ;

        return $user;
    }
}
