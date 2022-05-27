<?php

namespace Micro\Library\DTO;

use Micro\Library\DTO\Generator\Generator;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class GeneratorFacade implements GeneratorFacadeInterface
{
    public function __construct(
        private readonly DependencyInjectionInterface $dependencyInjection
    )
    {
    }


    /**
     * {@inheritDoc}
     */
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