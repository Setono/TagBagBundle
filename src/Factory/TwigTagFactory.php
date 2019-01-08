<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Factory;

use Setono\TagBagBundle\Tag\TagInterface;
use Setono\TagBagBundle\Tag\TypedTag;
use Symfony\Bridge\Twig\TwigEngine;

final class TwigTagFactory
{
    private $engine;

    public function __construct(TwigEngine $engine)
    {
        $this->engine = $engine;
    }

    /**
     * @param string $template
     * @param string $type
     * @param array  $parameters
     *
     * @return TypedTag
     *
     * @throws \Twig\Error\Error
     */
    public function create(string $template, string $type = TagInterface::TYPE_NONE, array $parameters = []): TypedTag
    {
        $res = $this->engine->render($template, $parameters);

        if (!is_string($res)) {
            throw new \RuntimeException(sprintf('Template `%s` could not be rendered', $template));
        }

        return new TypedTag($res, $type);
    }
}
