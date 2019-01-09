<?php

namespace spec\Setono\TagBagBundle\Tag;

use Setono\TagBagBundle\Tag\TypedTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class TypedTagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('tag', 'type');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TypedTag::class);
    }

    public function it_returns_correct_type(): void
    {
        $this->getType()->shouldReturn('type');
    }

    public function it_returns_correct_tag(): void
    {
        $this->__toString()->shouldReturn('tag');
    }
}
