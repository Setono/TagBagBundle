<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use Setono\TagBagBundle\Tag\ContentAwareInterface;
use Setono\TagBagBundle\Tag\TagInterface;

final class HtmlRenderer extends Renderer
{
    public function supports(TagInterface $tag): bool
    {
        return TagInterface::TYPE_HTML === $tag->getType() && $tag instanceof ContentAwareInterface;
    }

    public function render(TagInterface $tag): string
    {
        if (!$tag instanceof ContentAwareInterface) {
            throw new UnexpectedTypeException($tag, ContentAwareInterface::class);
        }

        return $tag->getContent();
    }
}
