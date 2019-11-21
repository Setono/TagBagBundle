<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;
use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use Setono\TagBagBundle\Tag\ContentAwareInterface;
use Setono\TagBagBundle\Tag\TagInterface;

final class ScriptRenderer extends Renderer
{
    public function supports(TagInterface $tag): bool
    {
        return TagInterface::TYPE_SCRIPT === $tag->getType() && $tag instanceof ContentAwareInterface;
    }

    /**
     * @throws PcreException
     * @throws StringsException
     */
    public function render(TagInterface $tag): string
    {
        if (!$tag instanceof ContentAwareInterface) {
            throw new UnexpectedTypeException($tag, ContentAwareInterface::class);
        }

        return $this->renderWithWrapper($tag->getContent(), '<script>');
    }
}
