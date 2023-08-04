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

use Symfony\Component\Validator\Constraints\Regex;

class RegexStrategy extends AbstractConstraintStrategy
{
    protected function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        $parent['pattern'] = $config['pattern'];
        $parent['match'] = $this->stringToBool($config['match'] ?? 'true');

        return $parent;
    }

    protected function getValidatorProperty(): string
    {
        return 'regex';
    }

    protected function getAttributeClassName(): string
    {
        return Regex::class;
    }
}
