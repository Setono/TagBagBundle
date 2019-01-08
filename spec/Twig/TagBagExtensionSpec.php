<?php

namespace spec\Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBag;
use Setono\TagBagBundle\Twig\TagBagExtension;
use PhpSpec\ObjectBehavior;
use Setono\TagBagBundle\TypeRenderer\CompositeTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\NoneTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\ScriptTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\StyleTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\TypeRendererInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TagBagExtensionSpec extends ObjectBehavior
{
    public function let(RequestStack $requestStack, Request $request, SessionInterface $session): void
    {
        $typeRenderer = new CompositeTypeRenderer(new NoneTypeRenderer(), new ScriptTypeRenderer(), new StyleTypeRenderer());

        $tagBag = $this->initTagBag();

        $requestStack->getCurrentRequest()->willReturn($request);
        $request->getSession()->willReturn($session);
        $session->getBag('tags')->willReturn($tagBag);


        $this->beConstructedWith($typeRenderer, $requestStack);
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBagExtension::class);
    }

    public function it_returns_empty_array_when_request_stack_is_null(TypeRendererInterface $typeRenderer): void
    {
        $this->beConstructedWith($typeRenderer, null);
        $this->tags()->shouldReturn('');
    }

    public function it_returns_empty_array_when_current_request_is_null(RequestStack $requestStack): void
    {
        $requestStack->getCurrentRequest()->willReturn(null);
        $this->tags()->shouldReturn('');
    }

    public function it_returns_empty_array_when_session_is_null(Request $request): void
    {
        $request->getSession()->willReturn(null);
        $this->tags()->shouldReturn('');
    }

    public function it_returns_all_tags(): void
    {
        $this->tags()->shouldReturn('tag1tag2tag3tag4tag5tag6');
    }

    public function it_returns_tags_in_section(): void
    {
        $this->tags('section1')->shouldReturn('tag1tag2');
    }

    public function it_returns_tags_in_multiple_sections(): void
    {
        $this->tags(['section1', 'section2'])->shouldReturn('tag1tag2tag3tag4');
    }

    private function initTagBag(): TagBag
    {
        $tagBag = new TagBag();
        $tagBag->add('tag1', 'section1');
        $tagBag->add('tag2', 'section1');
        $tagBag->add('tag3', 'section2');
        $tagBag->add('tag4', 'section2');
        $tagBag->add('tag5', 'section3');
        $tagBag->add('tag6', 'section3');

        return $tagBag;
    }
}
