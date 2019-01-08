<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TypeRenderer;

use Setono\TagBagBundle\Collection\TagCollection;
use Setono\TagBagBundle\Collection\TagCollectionInterface;

final class CompositeTypeRenderer extends TypeRenderer
{
    /**
     * @var TypeRendererInterface[]
     */
    private $typeRenderers = [];

    public function __construct(TypeRendererInterface ...$typeRenderers)
    {
        $this->typeRenderers = $typeRenderers;
    }

    public function render(TagCollectionInterface $tags): string
    {
        if (!$tags instanceof TagCollection) {
            throw new \RuntimeException(get_class($this).'::render() expects a '.TagCollection::class.' as first argument. '.get_class($tags).' given'); // @todo add exception class
        }

        foreach ($this->typeRenderers as $typeRenderer) {
            if ($typeRenderer->supports($tags->getType())) {
                return $typeRenderer->render($tags);
            }
        }

        throw new \RuntimeException('No type render for type '.$tags->getType()); // @todo add exception class
    }

    public function supports(string $type): bool
    {
        foreach ($this->typeRenderers as $typeRenderer) {
            if ($typeRenderer->supports($type)) {
                return true;
            }
        }

        return false;
    }
}
