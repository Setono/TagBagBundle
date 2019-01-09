<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

interface TypeRendererInterface
{
    /**
     * Will render the given tags.
     *
     * @param array $tags
     *
     * @return string
     */
    public function render(array $tags): string;

    /**
     * Returns true if this renderer supports the given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;
}
