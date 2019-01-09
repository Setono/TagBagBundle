<?php

namespace spec\Setono\TagBagBundle\Exception;

use Setono\TagBagBundle\Exception\WrongTagTypeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\TagBagBundle\Tag\ScriptTag;
use Setono\TagBagBundle\Tag\TagInterface;

class WrongTagTypeExceptionSpec extends ObjectBehavior
{
    private $tag;

    public function let(): void
    {
        $this->tag = new ScriptTag('tag');
        $this->beConstructedWith($this->tag, 'style');
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(WrongTagTypeException::class);
    }

    public function it_has_correct_message(): void
    {
        $this->getMessage()->shouldReturn('The tag '.get_class($this->tag).' has type script, but style was expected');
    }
}
