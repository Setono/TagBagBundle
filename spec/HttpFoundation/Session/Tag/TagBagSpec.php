<?php

namespace spec\Setono\TagBagBundle\HttpFoundation\Session\Tag;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBag;
use PhpSpec\ObjectBehavior;

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
        $expected = $this->addTag();
        $this->clear()->shouldReturn($expected);

        $this->all()->shouldReturn([]);
    }

    public function it_gets_section(): void
    {
        $this->add('tag1', 'section1');
        $this->add('tag2', 'section2');

        $this->get('section2')->shouldReturn([
            'tag2'
        ]);

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

    private function addTag(): array
    {
        $this->add('test', 'section');

        return [
            'section' => [
                'test'
            ]
        ];
    }
}
