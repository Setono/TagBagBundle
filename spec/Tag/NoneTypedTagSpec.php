<?php

namespace spec\Setono\TagBagBundle\Tag;

use Setono\TagBagBundle\Tag\NoneTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class NoneTypedTagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('tag');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(NoneTag::class);
    }

    public function it_returns_correct_type(): void
    {
        $this->getType()->shouldReturn('none');
    }
}
