<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

final class TwigTag implements TwigTagInterface
{
    /** @var string */
    private $template;

    /** @var array */
    private $parameters;

    /** @var string */
    private $type;

    /** @var string */
    private $key;

    public function __construct(string $template, string $type, string $key, array $parameters = [])
    {
        $this->template = $template;
        $this->parameters = $parameters;
        $this->type = $type;
        $this->key = $key;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getKey(): string
    {
        return $this->key;
    }

    public function getTemplate(): string
    {
        return $this->template;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
