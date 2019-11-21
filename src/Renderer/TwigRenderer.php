<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Renderer;

use Safe\Exceptions\PcreException;
use Safe\Exceptions\StringsException;
use function Safe\sprintf;
use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use Setono\TagBagBundle\Tag\TagInterface;
use Setono\TagBagBundle\Tag\TwigTagInterface;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

final class TwigRenderer extends Renderer
{
    /** @var Environment */
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
     * @throws LoaderError
     * @throws RuntimeError
     * @throws StringsException
     * @throws SyntaxError
     * @throws PcreException
     */
    public function render(TagInterface $tag): string
    {
        if (!$tag instanceof TwigTagInterface) {
            throw new UnexpectedTypeException($tag, TwigTagInterface::class);
        }

        $res = $this->environment->render($tag->getTemplate(), $tag->getParameters());

        return $this->renderWithWrapper($res, TagInterface::TYPE_HTML !== $tag->getType() ? sprintf('<%s>', $tag->getType()) : null);
    }
}
