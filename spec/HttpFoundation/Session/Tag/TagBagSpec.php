<?php

namespace spec\Setono\TagBagBundle\HttpFoundation\Session\Tag;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBag;
use PhpSpec\ObjectBehavior;
use Setono\TagBagBundle\Collection\TagCollectionInterface;
use Setono\TagBagBundle\Tag\TagInterface;

class TagBagSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBag::class);
    }

    public function it_gets_storage_key(): void
    {
        $this->getStorageKey()->shouldReturn('tags');
    }

    public function it_gets_name(): void
    {
        $this->getName()->shouldReturn('tags');
    }

    public function it_can_initialize_array(): void
    {
        $arr = ['test'];
        $this->getWrappedObject()->initialize($arr);

        $this->all()->shouldReturn(['test']);
    }

    public function it_clears(): void
    {
        $this->add('test', 'section');

        $actual = $this->clear();

        $actual->shouldBeArray();
        $actual->shouldHaveKey('section');
        $actual['section']->shouldBeArray();
        $actual['section']->shouldHaveKey(TagInterface::TYPE_NONE);
        $actual['section'][TagInterface::TYPE_NONE]->shouldBeAnInstanceOf(TagCollectionInterface::class);

        $this->all()->shouldReturn([]);
    }

    public function it_gets_section(): void
    {
        $this->add('tag1', 'section1');
        $this->add('tag2', 'section2');

        $actual = $this->get('section2');
        $actual->shouldBeArray();
        $actual[TagInterface::TYPE_NONE]->shouldBeAnInstanceOf(TagCollectionInterface::class);

        /** @var TagCollectionInterface $tags */
        $tags = $actual[TagInterface::TYPE_NONE];
        $tags->toArray()->shouldBeArray();

        /** @var TagInterface $tag */
        $tag = $tags->toArray()[0];
        $tag->__toString()->shouldBe('tag2');

        $this->get('section2', [])->shouldReturn([]);
    }

    public function it_returns_default_if_section_does_not_exist(): void
    {
        $this->add('tag1', 'section1');
        $this->add('tag2', 'section2');

        $this->get('section3', [])->shouldReturn([]);
    }

    public function it_returns_true_if_section_exists(): void
    {
        $this->add('tag', 'section');

        $this->has('section')->shouldReturn(true);
    }

    public function it_returns_false_if_section_does_not_exist(): void
    {
        $this->add('tag', 'section1');

        $this->has('section2')->shouldReturn(false);
    }

    public function it_returns_all_sections(): void
    {
        $this->add('tag', 'section1');
        $this->add('tag', 'section2');
        $this->add('tag', 'section3');
        $this->add('tag', 'section4');

        $this->keys()->shouldReturn(['section1', 'section2', 'section3', 'section4']);
    }
}
