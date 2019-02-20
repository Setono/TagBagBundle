<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBagBundle\Tag\TagInterface;

interface RendererInterface
{
    /**
     * Returns true if this renderer supports the given tag.
     *
     * @param TagInterface $tag
     *
     * @return bool
     */
    public function supports(TagInterface $tag): bool;

    /**
     * Returns a string based on the given tag.
     *
     * @param TagInterface $tag
     *
     * @return string
     */
    public function render(TagInterface $tag): string;
}
