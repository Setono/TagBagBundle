<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Collection\TagCollectionInterface;

interface TypeRendererInterface
{
    /**
     * Will render the given tags.
     *
     * @param TagCollectionInterface $tags
     *
     * @return string
     */
    public function render(TagCollectionInterface $tags): string;

    /**
     * Returns true if this renderer supports the given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function supports(string $type): bool;
}
