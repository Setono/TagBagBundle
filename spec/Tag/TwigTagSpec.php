<?php

namespace spec\Setono\TagBagBundle\Tag;

use Setono\TagBagBundle\Tag\TwigTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Bridge\Twig\TwigEngine;

class TwigTagSpec extends ObjectBehavior
{
    private const TEMPLATE = 'template';
    private const PARAMETERS = ['param1' => 'val1'];

    public function let(TwigEngine $engine): void
    {
        $this->beConstructedWith($engine, self::TEMPLATE, self::PARAMETERS);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TwigTag::class);
    }

    public function it_returns_string(TwigEngine $engine): void
    {
        $engine->render(self::TEMPLATE, self::PARAMETERS)->willReturn('string');

        $this->__toString()->shouldReturn('string');
    }

    public function it_throws_exception_if_engine_errors(TwigEngine $engine): void
    {
        $engine->render(Argument::cetera())->willReturn(false);

        $this->shouldThrow(\RuntimeException::class)->during('__toString');
    }
}
