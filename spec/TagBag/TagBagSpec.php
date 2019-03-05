<?php

namespace spec\Setono\TagBagBundle\TagBag;

use Setono\TagBagBundle\Renderer\CompositeRenderer;
use Setono\TagBagBundle\Renderer\HtmlRenderer;
use Setono\TagBagBundle\Renderer\ScriptRenderer;
use Setono\TagBagBundle\Renderer\StyleRenderer;
use Setono\TagBagBundle\Tag\HtmlTag;
use Setono\TagBagBundle\TagBag\TagBag;
use PhpSpec\ObjectBehavior;

class TagBagSpec extends ObjectBehavior
{
    public function let(): void
    {
        $renderer = new CompositeRenderer(new ScriptRenderer(), new StyleRenderer(), new HtmlRenderer());
        $this->beConstructedWith($renderer);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBag::class);
    }

    public function it_can_initialize_array(): void
    {
        $arr = ['test'];
        $this->getWrappedObject()->initialize($arr);

        $this->all()->shouldReturn(['test']);
    }

    public function it_gets_section(): void
    {
        $this->add(new HtmlTag('tag1', 'key'), 'section1');
        $this->add(new HtmlTag('tag2', 'key'), 'section2');

        $this->getSection('section2')->shouldReturn([
            'key' => 'tag2'
        ]);

        $this->getSection('section2')->shouldReturn([]);
    }

    public function it_returns_default_if_section_does_not_exist(): void
    {
        $this->add(new HtmlTag('tag1', 'key'), 'section1');
        $this->add(new HtmlTag('tag2', 'key'), 'section2');

        $this->getSection('section3', [])->shouldReturn([]);
    }

    public function it_overwrites_key_in_same_section(): void
    {
        $this->add(new HtmlTag('tag1', 'key'), 'section1');
        $this->add(new HtmlTag('tag2', 'key'), 'section1');

        $this->all()->shouldReturn([
            'section1' => [
                'key' => 'tag2'
            ]
        ]);
    }

    public function it_counts(): void
    {
        $this->add(new HtmlTag('tag1', 'key1'), 'section1');
        $this->add(new HtmlTag('tag2', 'key2'), 'section1');
        $this->add(new HtmlTag('tag1', 'key1'), 'section2');
        $this->add(new HtmlTag('tag2', 'key2'), 'section2');

        $this->count()->shouldReturn(4);
    }
}
