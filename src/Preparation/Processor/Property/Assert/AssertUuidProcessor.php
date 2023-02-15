<?php

declare(strict_types=1);


namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;


use Symfony\Component\Validator\Constraints\Uuid;

class AssertUuidProcessor extends AbstractConstraintProcessor
{

    const ALLOWED_VERSIONS = [
        Uuid::V1_MAC,
        Uuid::V2_DCE,
        Uuid::V3_MD5,
        Uuid::V4_RANDOM,
        Uuid::V5_SHA1,
        Uuid::V6_SORTABLE,
        Uuid::V7_MONOTONIC,
    ];

    protected function generateArguments(array $config, string $groupName): array
    {
        $parent =  parent::generateArguments($config, $groupName);



        return [
            ...$parent,
            'versions'  => $this->parseVersions(trim($config['versions'] ?? '')),
            'strict'    => $this->stringToBool($config['strict'] ?? 'true')
        ];
    }

    private function parseVersions(array|string $original): array
    {
        if($original === '') {
            return self::ALLOWED_VERSIONS;
        }

        $versions = $original;
        if(is_string($original)) {
            $versions = $this->explodeString($versions);
        }

        $versions = array_map('intval', $versions);

        dump(array_diff($versions, self::ALLOWED_VERSIONS));

        $isValid = !array_diff($versions, self::ALLOWED_VERSIONS);
        if($isValid) {
           return $versions;
        }

        throw new \InvalidArgumentException(sprintf(
            'UUID versions is not allowed. Actual: `%s`, Available: `%s`',
            $original,
            implode(',', self::ALLOWED_VERSIONS)
        ));
    }

    protected function getValidatorProperty(): string
    {
        return 'uuid';
    }

    protected function getAttributeClassName(): string
    {
        return Uuid::class;
    }
}
