<?php

namespace spec\Setono\TagBagBundle\Factory;

use Setono\TagBagBundle\Factory\TwigTagFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\TagBagBundle\Tag\TypedTag;
use Symfony\Bridge\Twig\TwigEngine;

class TwigTagFactorySpec extends ObjectBehavior
{
    public function let(TwigEngine $engine): void
    {
        $this->beConstructedWith($engine);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TwigTagFactory::class);
    }

    public function it_creates(TwigEngine $engine): void
    {
        $engine->render(Argument::cetera())->willReturn('tag');

        $this->create(Argument::any())->shouldReturnAnInstanceOf(TypedTag::class);
    }
}
