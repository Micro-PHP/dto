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

namespace Micro\Library\DTO;

use Micro\Library\DTO\Object\AbstractDto;
use Micro\Library\DTO\Validator\ValidatorFactoryInterface;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class ValidatorFacade implements ValidatorFacadeInterface
{
    public function __construct(
        private readonly ValidatorFactoryInterface $validatorFactory
    ) {
    }

    public function validate(AbstractDto $dto, array|string $groups = 'Default'): ConstraintViolationListInterface
    {
        return $this->validatorFactory->create()->validate($dto, $groups);
    }
}
