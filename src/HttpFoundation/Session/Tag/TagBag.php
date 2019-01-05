<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session\Tag;

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

    public function add($tag, string $section): void
    {
        $this->tags[$section][] = (string) $tag;
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
}
