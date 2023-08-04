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

use Symfony\Component\Validator\Constraints\Expression;

class ExpressionStrategy extends AbstractConstraintStrategy
{
    public function generateArguments(array $config): array
    {
        $parent = parent::generateArguments($config);

        $parent['expression'] = $config['expression'];

        $this->provideValues($parent, $config);

        return $parent;
    }

    /**
     * @param array<string, mixed> $args
     * @param array<string, mixed> $config
     *
     * @return void
     */
    protected function provideValues(array &$args, array $config): void
    {
        if (empty($config['variable'])) {
            return;
        }

        $values = [];
        foreach ($config['variable'] as $value) {
            $values[$value['name']] = $this->sanitize($value['value']);
        }

        $args['values'] = $values;
    }

    protected function getValidatorProperty(): string
    {
        return 'expression';
    }

    protected function getAttributeClassName(): string
    {
        return Expression::class;
    }
}
