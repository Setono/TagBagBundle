<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session\Tag;

use Setono\TagBagBundle\Exception\WrongTagTypeException;
use Setono\TagBagBundle\Collection\TagCollectionInterface;
use Setono\TagBagBundle\Tag\TagInterface;
use Setono\TagBagBundle\Tag\TypedTag;
use Setono\TagBagBundle\Collection\TagCollection;

class TagBag implements TagBagInterface
{
    /**
     * @var string
     */
    private $storageKey;

    /**
     * @var string
     */
    private $name = 'tags';

    /**
     * @var TagCollectionInterface[][]
     */
    private $tags = [];

    public function __construct(string $storageKey = 'tags')
    {
        $this->storageKey = $storageKey;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function initialize(array &$tags): void
    {
        $this->tags = &$tags;
    }

    public function getStorageKey(): string
    {
        return $this->storageKey;
    }

    public function clear(): array
    {
        return $this->all();
    }

    public function add($tag, string $section, string $type = null): void
    {
        $tag = $this->getTagObject($tag, $type);

        if (!isset($this->tags[$section][$tag->getType()])) {
            $this->tags[$section][$tag->getType()] = new TagCollection($tag->getType());
        }

        $this->tags[$section][$tag->getType()]->add($tag);
    }

    public function addScript($tag, string $section): void
    {
        $this->add($tag, $section, TagInterface::TYPE_SCRIPT);
    }

    public function addStyle($tag, string $section): void
    {
        $this->add($tag, $section, TagInterface::TYPE_STYLE);
    }

    public function get(string $section, array $default = []): array
    {
        if (!$this->has($section)) {
            return $default;
        }

        $return = $this->tags[$section];

        unset($this->tags[$section]);

        return $return;
    }

    public function all(): array
    {
        $tags = $this->tags;
        $this->tags = [];

        return $tags;
    }

    public function has(string $section): bool
    {
        return array_key_exists($section, $this->tags) && $this->tags[$section];
    }

    public function keys(): array
    {
        return array_keys($this->tags);
    }

    protected function getTagObject($tag, ?string $expectedType): TagInterface
    {
        if (null === $expectedType) {
            $expectedType = $this->getType($tag, TagInterface::TYPE_NONE);
        }

        if (is_string($tag)) {
            $tag = new TypedTag($tag, $expectedType);
        }

        if ($tag->getType() !== $expectedType) {
            throw new WrongTagTypeException($tag, $expectedType);
        }

        return $tag;
    }

    protected function getType($tag, string $default): string
    {
        $type = $default;

        if ($tag instanceof TagInterface) {
            $type = $tag->getType();
        }

        return $type;
    }
}
