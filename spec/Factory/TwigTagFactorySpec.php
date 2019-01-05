<?php

namespace spec\Setono\TagBagBundle\Factory;

use Setono\TagBagBundle\Factory\TwigTagFactory;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\TagBagBundle\Tag\TwigTag;
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

    public function it_creates_twig_tag(): void
    {
        $this->create(Argument::cetera())->shouldReturnAnInstanceOf(TwigTag::class);
    }
}
