<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Collection;

use Countable;
use Setono\TagBagBundle\Exception\WrongTagTypeException;
use Setono\TagBagBundle\Tag\TagInterface;

/**
 * A tag collection is a collection of tags with identical type.
 */
interface TagCollectionInterface extends Countable
{
    /**
     * Adds a tag to the tag collection.
     *
     * @param TagInterface $tag
     *
     * @throws WrongTagTypeException if the type of the tag does not match the type of collection
     */
    public function add(TagInterface $tag): void;

    /**
     * @return array
     */
    public function toArray(): array;

    /**
     * Returns the type for this collection.
     *
     * @return string
     */
    public function getType(): string;
}
