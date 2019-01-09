<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session\Tag;

use Setono\TagBagBundle\Exception\WrongTagTypeException;
use Setono\TagBagBundle\Tag\TagInterface;

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
     * @var array
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
        if (null !== $type && $tag instanceof TagInterface && $type !== $tag->getType()) {
            throw new WrongTagTypeException($tag, $type);
        }

        $type = $this->resolveType($tag, $type, TagInterface::TYPE_NONE);

        $this->tags[$section][$type][] = (string) $tag;
    }

    public function addScript($tag, string $section): void
    {
        $this->add($tag, $section, TagInterface::TYPE_SCRIPT);
    }

    public function addStyle($tag, string $section): void
    {
        $this->add($tag, $section, TagInterface::TYPE_STYLE);
    }

    public function getSection(string $section, array $default = []): array
    {
        if (!$this->hasSection($section)) {
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

    public function hasSection(string $section): bool
    {
        return array_key_exists($section, $this->tags) && $this->tags[$section];
    }

    public function getSections(): array
    {
        return array_keys($this->tags);
    }

    public function hasTags(string $section, string $type): bool
    {
        if (!$this->hasSection($section)) {
            return false;
        }

        return array_key_exists($type, $this->tags[$section]) && $this->tags[$section][$type];
    }

    public function getTags(string $section, string $type, array $default = []): array
    {
        if (!$this->hasTags($section, $type)) {
            return $default;
        }

        $return = $this->tags[$section][$type];

        unset($this->tags[$section][$type]);

        return $return;
    }

    public function getTypes(string $section): array
    {
        if (!$this->hasSection($section)) {
            return [];
        }

        return array_keys($this->tags[$section]);
    }

    protected function resolveType($tag, ?string $type, string $defaultType): string
    {
        if ($tag instanceof TagInterface) {
            return $tag->getType();
        }

        if (null !== $type) {
            return $type;
        }

        return $defaultType;
    }
}
