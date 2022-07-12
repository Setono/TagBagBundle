<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\Tag\TemplateTagInterface;
use Twig\Environment;
use Webmozart\Assert\Assert;

final class TwigRenderer implements RendererInterface
{
    private Environment $environment;

    public function __construct(Environment $environment)
    {
        $this->environment = $environment;
    }

    /**
     * @psalm-assert-if-true TemplateTagInterface $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof TemplateTagInterface && $tag->getTemplateType() === 'twig';
    }

    /**
     * @param TagInterface|TemplateTagInterface $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return $this->environment->render($tag->getTemplate(), $tag->getData());
    }
}
