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

namespace Micro\Library\DTO\Preparation\Processor\Property\Assert;

use Symfony\Component\Validator\Constraints\Ip;

class IpStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);
        $parent['version'] = $config['version'] ?? '4';

        return $parent;
    }

    protected function getValidatorProperty(): string
    {
        return 'ip';
    }

    protected function getAttributeClassName(): string
    {
        return Ip::class;
    }
}
