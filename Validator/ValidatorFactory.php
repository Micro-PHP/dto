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

use Psr\Cache\CacheItemPoolInterface;
use Symfony\Component\Validator\Mapping\Factory\LazyLoadingMetadataFactory;
use Symfony\Component\Validator\Mapping\Loader\AnnotationLoader;
use Symfony\Component\Validator\Validation;

readonly class ValidatorFactory implements ValidatorFactoryInterface
{
    public function __construct(
        private CacheItemPoolInterface|null $cacheItemPool = null,
        private string|null $translationDomain = null
    ) {
    }

    public function create(): ValidatorInterface
    {
        $mf = new LazyLoadingMetadataFactory(new AnnotationLoader());

        $vb = Validation::createValidatorBuilder();
        $vb->setMetadataFactory($mf);
        if ($this->cacheItemPool) {
            $vb->setMappingCache($this->cacheItemPool);
        }

        if ($this->translationDomain) {
            $vb->setTranslationDomain($this->translationDomain);
        }

        $vb->disableAnnotationMapping();
        $validator = $vb->getValidator();

        return new Validator($validator);
    }
}
