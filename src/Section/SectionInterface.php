<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Section;

use Setono\TagBagBundle\Collection\TagCollectionInterface;
use Setono\TagBagBundle\Tag\TagInterface;

interface SectionInterface
{
    /**
     * @return TagCollectionInterface[]
     */
    public function getTags(): array;

    /**
     * @param string $type
     *
     * @return TagCollectionInterface
     */
    public function getTagsByType(string $type): TagCollectionInterface;

    /**
     * Returns true if this section has the given type.
     *
     * @param string $type
     *
     * @return bool
     */
    public function hasType(string $type): bool;

    /**
     * @param TagInterface $tag
     * @param string       $type
     */
    public function addTag(TagInterface $tag, string $type): void;
}
