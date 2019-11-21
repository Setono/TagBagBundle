<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

class ContentTag implements TagInterface, ContentAwareInterface
{
    /** @var string */
    protected $content;

    /** @var string */
    protected $type;

    /** @var string */
    protected $key;

    public function __construct(string $content, string $type, string $key)
    {
        $this->content = $content;
        $this->type = $type;
        $this->key = $key;
    }

    public function getContent(): string
    {
        return $this->content;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getKey(): string
    {
        return $this->key;
    }
}
