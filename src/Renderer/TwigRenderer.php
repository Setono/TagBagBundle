<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Setono\TagBag\Renderer\RendererInterface;
use Setono\TagBag\Tag\TagInterface;
use Setono\TagBag\Tag\TemplateTag;
use Twig\Environment;
use Webmozart\Assert\Assert;

final class TwigRenderer implements RendererInterface
{
    public function __construct(private readonly Environment $environment)
    {
    }

    /**
     * @psalm-assert-if-true TemplateTag $tag
     */
    public function supports(TagInterface $tag): bool
    {
        return $tag instanceof TemplateTag && $tag->getTemplateType() === 'twig';
    }

    /**
     * @param TagInterface|TemplateTag $tag
     */
    public function render(TagInterface $tag): string
    {
        Assert::true($this->supports($tag));

        return $this->environment->render($tag->getTemplate(), $tag->getData());
    }
}
