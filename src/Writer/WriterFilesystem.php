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

namespace Micro\Library\DTO\Writer;

class WriterFilesystem implements WriterInterface
{
    /**
     * @param string $classFilePath
     * @param string $namespaceGeneral
     */
    public function __construct(
        private readonly string $classFilePath,
        private readonly string $namespaceGeneral,
    ) {
    }

    /**
     * @param string $classnameFull
     * @param string $renderedClassData
     *
     * @throws \Exception
     *
     * @return void
     */
    public function write(string $classnameFull, string $renderedClassData): void
    {
        $meta = $this->getClassFileMeta($classnameFull);
        $file = $meta['file'];
        $path = $meta['path'];

        $this->createPath($path);

        file_put_contents($path.\DIRECTORY_SEPARATOR.$file, $renderedClassData);
    }

    /**
     * @param string $classnameFull
     *
     * @return array<string, string>
     */
    protected function getClassFileMeta(string $classnameFull): array
    {
        $namespaceGeneralExploded = explode('\\', $this->namespaceGeneral);
        $classExploded = explode('\\', $classnameFull);
        $explodedFile = array_values(array_diff($classExploded, $namespaceGeneralExploded));

        $file = $explodedFile[0];
        $path = rtrim($this->classFilePath, '\\');
        if (1 !== \count($classExploded)) {
            $file = array_pop($explodedFile);
            $path = $path.'\\'.implode(\DIRECTORY_SEPARATOR, $explodedFile);
        }

        return [
            'file' => $file.'.php',
            'path' => str_replace('\\', '/', $path),
        ];
    }

    /**
     * @param string $path
     *
     * @throws \Exception
     *
     * @return void
     */
    protected function createPath(string $path): void
    {
        $path = preg_replace('(\/+\/)', '/', $path);

        if (file_exists($path)) {
            return;
        }

        if (!mkdir($path, 0755, true)) {
            throw new \Exception(sprintf('Can not create path %s', $path));
        }
    }
}
