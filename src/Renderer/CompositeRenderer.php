<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Safe\Exceptions\StringsException;
use Setono\TagBagBundle\Exception\UnsupportedTagException;
use Setono\TagBagBundle\Tag\TagInterface;

final class CompositeRenderer implements RendererInterface
{
    /** @var RendererInterface[] */
    private $tagRenderers;

    public function __construct(RendererInterface ...$tagRenderers)
    {
        $this->tagRenderers = $tagRenderers;
    }

    public function supports(TagInterface $tag): bool
    {
        foreach ($this->tagRenderers as $tagRenderer) {
            if ($tagRenderer->supports($tag)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @throws StringsException
     */
    public function render(TagInterface $tag): string
    {
        foreach ($this->tagRenderers as $tagRenderer) {
            if ($tagRenderer->supports($tag)) {
                return $tagRenderer->render($tag);
            }
        }

        throw new UnsupportedTagException($tag);
    }
}
