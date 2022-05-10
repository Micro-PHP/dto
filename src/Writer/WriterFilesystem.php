<?php

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
    )
    {
    }

    /**
     * @param string $classnameFull
     * @param string $renderedClassData
     * @return void
     * @throws \Exception
     */
    public function write(string $classnameFull, string $renderedClassData): void
    {
        $meta = $this->getClassFileMeta($classnameFull);
        $file = $meta['file'];
        $path = $meta['path'];

        $this->createPath($path);

        file_put_contents($path . DIRECTORY_SEPARATOR . $file, $renderedClassData);
    }

    /**
     * @param string $classnameFull
     * @return array
     */
    protected function getClassFileMeta(string $classnameFull): array
    {
        $shortClassAlias = ltrim(ltrim($classnameFull, $this->namespaceGeneral),'\\');
        $classExploded = explode('\\', $shortClassAlias);
        $file = $classExploded[0];
        $path = rtrim($this->classFilePath, '\\');
        if(count($classExploded) !== 1) {
            $file = array_pop($classExploded);
            $path = $path . '\\' . implode(DIRECTORY_SEPARATOR, $classExploded);
        }

        return [
            'file'  => $file . '.php',
            'path'  => str_replace('\\', '/', $path),
        ];
    }

    /**
     * @param string $path
     * @return void
     * @throws \Exception
     */
    protected function createPath(string $path): void
    {
        $path = preg_replace('(\/+\/)', '/', $path);

        if(file_exists($path)) {
            return;
        }

        if(!mkdir($path, 0755, true)) {
            throw new \Exception(sprintf('Can not create path %s', $path));
        }
    }
}