<?php

namespace spec\Setono\TagBagBundle\Tag;

use Setono\TagBagBundle\Tag\ScriptTag;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ScriptTagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('tag', 'key');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ScriptTag::class);
    }

    public function it_returns_correct_type(): void
    {
        $this->getType()->shouldReturn('script');
    }

    public function it_returns_correct_key(): void
    {
        $this->getKey()->shouldReturn('key');
    }
}
