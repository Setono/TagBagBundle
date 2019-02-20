<?php

namespace spec\Setono\TagBagBundle\Tag;

use Setono\TagBagBundle\Tag\ContentTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ContentTagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('tag', 'type', 'key');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ContentTag::class);
    }

    public function it_returns_correct_tag(): void
    {
        $this->getContent()->shouldReturn('tag');
    }

    public function it_returns_correct_type(): void
    {
        $this->getType()->shouldReturn('type');
    }

    public function it_returns_correct_key(): void
    {
        $this->getKey()->shouldReturn('key');
    }
}
