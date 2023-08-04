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

use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;

class GreaterThanOrEqualStrategy extends AbstractComparisonStrategy
{
    protected function getValidatorProperty(): string
    {
        return 'greater_than_or_equal';
    }

    protected function getAttributeClassName(): string
    {
        return GreaterThanOrEqual::class;
    }
}
