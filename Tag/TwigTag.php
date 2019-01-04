<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tag;

use Symfony\Bridge\Twig\TwigEngine;

final class TwigTag implements TagInterface
{
    /**
     * @var TwigEngine
     */
    private $engine;

    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $parameters;

    public function __construct(TwigEngine $engine, string $template, array $parameters = [])
    {
        $this->engine = $engine;
        $this->template = $template;
        $this->parameters = $parameters;
    }

    /**
     * @return string
     *
     * @throws \Twig\Error\Error
     */
    public function __toString(): string
    {
        $res = $this->engine->render($this->template, $this->parameters);

        if (!is_string($res)) {
            throw new \RuntimeException(sprintf('Template `%s` could not be rendered', $this->template));
        }

        return $res;
    }
}
