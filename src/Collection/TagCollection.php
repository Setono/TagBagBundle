<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Collection;

use Setono\TagBagBundle\Exception\WrongTagTypeException;
use Setono\TagBagBundle\Tag\TagInterface;

final class TagCollection implements TagCollectionInterface
{
    /**
     * @var string
     */
    private $type;

    /**
     * @var TagInterface[]
     */
    private $tags = [];

    public function __construct(string $type, array $tags = [])
    {
        $this->type = $type;

        foreach ($tags as $tag) {
            $this->add($tag);
        }
    }

    public function add(TagInterface $tag): void
    {
        if ($tag->getType() !== $this->type) {
            throw new WrongTagTypeException($tag, $this->type);
        }

        $this->tags[] = $tag;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function toArray(): array
    {
        return $this->tags;
    }

    public function count(): int
    {
        return \count($this->tags);
    }
}
