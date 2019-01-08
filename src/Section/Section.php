<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Section;

use Setono\TagBagBundle\Collection\TagCollection;
use Setono\TagBagBundle\Collection\TagCollectionInterface;
use Setono\TagBagBundle\Tag\TagInterface;

final class Section implements SectionInterface
{
    /**
     * @var TagCollectionInterface[]
     */
    private $tags = [];

    public function getTags(): array
    {
        return $this->tags;
    }

    public function getTagsByType(string $type): TagCollectionInterface
    {
        if (!$this->hasType($type)) {
            throw new \RuntimeException('This section does not have any tags with type '.$type); // @todo fix better exception
        }

        return $this->tags[$type];
    }

    public function hasType(string $type): bool
    {
        return array_key_exists($type, $this->tags) && $this->tags[$type] instanceof TagCollectionInterface;
    }

    public function addTag(TagInterface $tag, string $type): void
    {
        if (!isset($this->tags[$type])) {
            $this->tags[$type] = new TagCollection($type);
        }

        $this->tags[$type]->add($tag);
    }
}
