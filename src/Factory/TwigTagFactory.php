<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Factory;

use Setono\TagBagBundle\Tag\TwigTag;
use Symfony\Bridge\Twig\TwigEngine;

final class TwigTagFactory
{
    private $engine;

    public function __construct(TwigEngine $engine)
    {
        $this->engine = $engine;
    }

    public function create(string $template, array $parameters = []): TwigTag
    {
        return new TwigTag($this->engine, $template, $parameters);
    }
}
