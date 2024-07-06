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

namespace Micro\Library\DTO\Validator;

use Micro\Library\DTO\Object\AbstractDto;
use Symfony\Component\Validator\ConstraintViolationListInterface;

interface ValidatorInterface
{
    /**
     * @param string[]|string $groups
     */
    public function validate(AbstractDto $dto, array|string $groups = 'Default'): ConstraintViolationListInterface;
}
