<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBagBundle\Tag\TagInterface;

interface RendererInterface
{
    /**
     * Returns true if this renderer supports the given tag.
     */
    public function supports(TagInterface $tag): bool;

    /**
     * Returns a string based on the given tag.
     */
    public function render(TagInterface $tag): string;
}
