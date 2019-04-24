<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

interface TwigTagInterface extends TagInterface
{
    /**
     * Returns the twig template.
     *
     * @return string
     */
    public function getTemplate(): string;

    /**
     * Returns the parameters to inject into the twig template when rendered.
     *
     * @return array
     */
    public function getParameters(): array;
}
