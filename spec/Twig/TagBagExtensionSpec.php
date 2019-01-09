<?php

namespace spec\Setono\TagBagBundle\Twig;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBag;
use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface;
use Setono\TagBagBundle\Registry\TypeRendererRegistry;
use Setono\TagBagBundle\Tag\TagInterface;
use Setono\TagBagBundle\Twig\TagBagExtension;
use PhpSpec\ObjectBehavior;
use Setono\TagBagBundle\TypeRenderer\NoneTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\ScriptTypeRenderer;
use Setono\TagBagBundle\TypeRenderer\StyleTypeRenderer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TagBagExtensionSpec extends ObjectBehavior
{
    public function let(RequestStack $requestStack, Request $request, SessionInterface $session): void
    {
        $typeRendererRegistry = new TypeRendererRegistry();
        $typeRendererRegistry->register('none', new NoneTypeRenderer());
        $typeRendererRegistry->register('script', new ScriptTypeRenderer());
        $typeRendererRegistry->register('style', new StyleTypeRenderer());

        $tagBag = new TagBag();
        $this->initTagBag($tagBag);

        $requestStack->getCurrentRequest()->willReturn($request);
        $request->getSession()->willReturn($session);
        $session->getBag('tags')->willReturn($tagBag);


        $this->beConstructedWith($typeRendererRegistry, $requestStack);
    }
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TagBagExtension::class);
    }

    public function it_returns_empty_array_when_request_stack_is_null(): void
    {
        $this->beConstructedWith(new TypeRendererRegistry(), null);
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
        $this->tags()->shouldReturn('<style>tag1</style>tag2<script>tag3tag4</script>tag5tag8<style>tag6</style><script>tag7</script>');
    }

    public function it_returns_tags_in_section(): void
    {
        $this->tags('section1')->shouldReturn('<style>tag1</style>tag2');
    }

    public function it_returns_tags_in_multiple_sections(): void
    {
        $this->tags(['section1', 'section2'])->shouldReturn('<style>tag1</style>tag2<script>tag3tag4</script>');
    }

    private function initTagBag(TagBagInterface $tagBag): void
    {
        $tagBag->add('tag1', 'section1', TagInterface::TYPE_STYLE);
        $tagBag->add('tag2', 'section1', TagInterface::TYPE_NONE);
        $tagBag->add('tag3', 'section2', TagInterface::TYPE_SCRIPT);
        $tagBag->add('tag4', 'section2', TagInterface::TYPE_SCRIPT);
        $tagBag->add('tag5', 'section3', TagInterface::TYPE_NONE);
        $tagBag->add('tag6', 'section3', TagInterface::TYPE_STYLE);
        $tagBag->add('tag7', 'section3', TagInterface::TYPE_SCRIPT);
        $tagBag->add('tag8', 'section3');
    }
}
