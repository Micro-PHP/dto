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

use Micro\Library\DTO\Generator\Generator;

class GeneratorFacade implements GeneratorFacadeInterface
{
    public function __construct(
        private readonly DependencyInjectionInterface $dependencyInjection
    ) {
    }

    public function generate(): void
    {
        $generator = new Generator(
            $this->dependencyInjection->createReader(),
            $this->dependencyInjection->createWriter(),
            $this->dependencyInjection->createRenderer(),
            $this->dependencyInjection->createClassPreparationProcessor(),
            $this->dependencyInjection->getLogger()
        );

        $generator->generate();
    }
}
