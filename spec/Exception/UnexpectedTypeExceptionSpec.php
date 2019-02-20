<?php

namespace spec\Setono\TagBagBundle\Exception;

use Setono\TagBagBundle\Exception\UnexpectedTypeException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class UnexpectedTypeExceptionSpec extends ObjectBehavior
{
    private $tag;

    public function let(): void
    {
        $this->beConstructedWith(new \stdClass(), 'type');
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(UnexpectedTypeException::class);
    }

    public function it_has_correct_message(): void
    {
        $this->getMessage()->shouldReturn('Expected argument of type type, stdClass given');
    }
}
