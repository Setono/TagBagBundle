<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

class TypedTag implements TagInterface
{
    /**
     * @var string
     */
    protected $tag;

    /**
     * @var string
     */
    protected $type = self::TYPE_NONE;

    public function __construct(string $tag, string $type)
    {
        $this->tag = $tag;
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function __toString(): string
    {
        return $this->tag;
    }
}
