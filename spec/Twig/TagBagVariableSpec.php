<?php

namespace spec\Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBag;
use Setono\TagBagBundle\Twig\TagBagVariable;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TagBagVariableSpec extends ObjectBehavior
{
    public function let(RequestStack $requestStack, Request $request, SessionInterface $session): void
    {
        $tagBagContents = $this->tagBagContents();

        $tagBag = new TagBag();
        $tagBag->initialize($tagBagContents);

        $requestStack->getCurrentRequest()->willReturn($request);
        $request->getSession()->willReturn($session);
        $session->getBag('tags')->willReturn($tagBag);


        $this->beConstructedWith($requestStack);
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBagVariable::class);
    }

    public function it_returns_empty_array_when_request_stack_is_null(): void
    {
        $this->beConstructedWith(null);
        $this->getTags()->shouldReturn([]);
    }

    public function it_returns_empty_array_when_current_request_is_null(RequestStack $requestStack): void
    {
        $requestStack->getCurrentRequest()->willReturn(null);
        $this->getTags()->shouldReturn([]);
    }

    public function it_returns_empty_array_when_session_is_null(Request $request): void
    {
        $request->getSession()->willReturn(null);
        $this->getTags()->shouldReturn([]);
    }

    public function it_returns_all_tags(): void
    {
        $this->getTags()->shouldReturn($this->tagBagContents());
    }

    public function it_returns_tags_in_section(): void
    {
        $this->getTags('section1')->shouldReturn([
            'tag1', 'tag2'
        ]);
    }

    public function it_returns_tags_in_multiple_sections(): void
    {
        $this->getTags(['section1', 'section2'])->shouldReturn([
            'section1' => [
                'tag1', 'tag2'
            ],
            'section2' => [
                'tag3', 'tag4'
            ],
        ]);
    }

    private function tagBagContents(): array
    {
        return [
            'section1' => [
                'tag1', 'tag2'
            ],
            'section2' => [
                'tag3', 'tag4'
            ],
            'section3' => [
                'tag5', 'tag6'
            ]
        ];
    }
}
