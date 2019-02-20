<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use Setono\TagBagBundle\Tag\TagInterface;
use Setono\TagBagBundle\Tag\TwigTagInterface;
use Twig\Environment;

final class TwigRenderer extends Renderer
{
    private $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof TwigTagInterface;
    }

    /**
     * @param TagInterface $tag
     *
     * @return string
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function render(TagInterface $tag): string
    {
        if (!$tag instanceof TwigTagInterface) {
            throw new UnexpectedTypeException($tag, TwigTagInterface::class);
        }

        $res = $this->environment->render($tag->getTemplate(), $tag->getParameters());

        if (!is_string($res)) {
            throw new \RuntimeException(sprintf('Template `%s` could not be rendered', $tag->getTemplate()));
        }

        return $this->renderWithWrapper($res, TagInterface::TYPE_HTML !== $tag->getType() ? sprintf('<%s>', $tag->getType()) : null);
    }
}
