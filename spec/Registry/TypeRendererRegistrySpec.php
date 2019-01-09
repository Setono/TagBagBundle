<?php

namespace spec\Setono\TagBagBundle\Registry;

use Setono\TagBagBundle\Exception\ExistingTypeRendererException;
use Setono\TagBagBundle\Exception\NonExistentTypeRendererException;
use Setono\TagBagBundle\Registry\TypeRendererRegistry;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;

class TypeRendererRegistrySpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TypeRendererRegistry::class);
    }

    public function it_returns_true_if_type_renderer_is_present(TypeRendererInterface $typeRenderer): void
    {
        $this->register('style', $typeRenderer);

        $this->has('style')->shouldReturn(true);
    }

    public function it_returns_type_renderer(TypeRendererInterface $typeRenderer): void
    {
        $this->register('style', $typeRenderer);

        $this->get('style')->shouldReturn($typeRenderer);
    }

    public function it_throws_exception_if_type_renderer_does_not_exist(): void
    {
        $this->shouldThrow(NonExistentTypeRendererException::class)->during('get', ['style']);
    }

    public function it_throws_exception_if_type_renderer_already_exists(TypeRendererInterface $typeRenderer1, TypeRendererInterface $typeRenderer2): void
    {
        $this->register('style', $typeRenderer1);
        $this->shouldThrow(ExistingTypeRendererException::class)->during('register', ['style', $typeRenderer2]);
    }
}
