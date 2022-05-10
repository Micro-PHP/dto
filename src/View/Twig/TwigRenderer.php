<?php

namespace Micro\Library\DTO\View\Twig;

use Micro\Library\DTO\View\RendererInterface;
use Twig\Environment;

class TwigRenderer implements RendererInterface
{

    public function __construct(
        private readonly Environment $environment,
        private string $template
    ) {

    }

    /**
     * @param array $classData
     * @return string
     *
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function render(array $classData): string
    {
        return $this->environment->render($this->template, $classData);
    }
}