<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

final class TwigTag implements TwigTagInterface
{
    private $template;
    private $parameters;
    private $type;

    public function __construct(string $template, string $type, array $parameters = [])
    {
        $this->template = $template;
        $this->parameters = $parameters;
        $this->type = $type;
    }

    public function getType(): string
    {
        return $this->type;
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
