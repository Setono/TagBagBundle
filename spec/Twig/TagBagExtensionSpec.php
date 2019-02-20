<?php

namespace spec\Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\Renderer\CompositeRenderer;
use Setono\TagBagBundle\Renderer\HtmlRenderer;
use Setono\TagBagBundle\Renderer\ScriptRenderer;
use Setono\TagBagBundle\Renderer\StyleRenderer;
use Setono\TagBagBundle\Tag\HtmlTag;
use Setono\TagBagBundle\Tag\ScriptTag;
use Setono\TagBagBundle\Tag\StyleTag;
use Setono\TagBagBundle\TagBag\TagBag;
use Setono\TagBagBundle\TagBag\TagBagInterface;
use PhpSpec\ObjectBehavior;
use Setono\TagBagBundle\Twig\TagBagExtension;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TagBagExtensionSpec extends ObjectBehavior
{
    public function let(RequestStack $requestStack, Request $request, SessionInterface $session): void
    {
        $renderer = new CompositeRenderer(new ScriptRenderer(), new StyleRenderer(), new HtmlRenderer());
        $tagBag = new TagBag($renderer);
        $this->initTagBag($tagBag);

        $requestStack->getCurrentRequest()->willReturn($request);
        $request->getSession()->willReturn($session);
        $session->getBag(TagBag::NAME)->willReturn($tagBag);


        $this->beConstructedWith($requestStack);
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBagExtension::class);
    }

    public function it_returns_empty_array_when_request_stack_is_null(): void
    {
        $this->beConstructedWith(null);
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
        $this->tags()->shouldReturn('<style>tag1</style>tag2<script>tag3</script><script>tag4</script>tag5<style>tag6</style><script>tag7</script>tag8');
    }

    public function it_returns_tags_in_section(): void
    {
        $this->tags('section1')->shouldReturn('<style>tag1</style>tag2');
    }

    public function it_returns_tags_in_multiple_sections(): void
    {
        $this->tags(['section1', 'section2'])->shouldReturn('<style>tag1</style>tag2<script>tag3</script><script>tag4</script>');
    }

    private function initTagBag(TagBagInterface $tagBag): void
    {
        $tagBag->add(new StyleTag('tag1', 'key1'), 'section1');
        $tagBag->add(new HtmlTag('tag2', 'key2'), 'section1');
        $tagBag->add(new ScriptTag('tag3', 'key3'), 'section2');
        $tagBag->add(new ScriptTag('tag4', 'key4'), 'section2');
        $tagBag->add(new HtmlTag('tag5', 'key5'), 'section3');
        $tagBag->add(new StyleTag('tag6', 'key6'), 'section3');
        $tagBag->add(new ScriptTag('tag7', 'key7'), 'section3');
        $tagBag->add(new HtmlTag('tag8', 'key8'), 'section3');
    }
}
