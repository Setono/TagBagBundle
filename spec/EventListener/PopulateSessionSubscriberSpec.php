<?php

namespace spec\Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\EventListener\PopulateSessionSubscriber;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class PopulateSessionSubscriberSpec extends ObjectBehavior
{
    private $sessionKey = 'session_key';

    public function let(TagBagInterface $tagBag): void
    {
        $this->beConstructedWith($tagBag, $this->sessionKey);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(PopulateSessionSubscriber::class);
    }

    public function it_listens_to_response_event(): void
    {
        $this::getSubscribedEvents()->shouldHaveKey(KernelEvents::FINISH_REQUEST);
    }

    public function it_does_not_set_session_request_is_not_master_request(FinishRequestEvent $event, Request $request): void
    {
        $event->isMasterRequest()->willReturn(false);
        $event->getRequest()->shouldNotBeCalled();

        $this->populate($event);
    }

    public function it_does_not_set_session_when_session_is_null(FinishRequestEvent $event, Request $request, SessionInterface $session): void
    {
        $request->getSession()->willReturn(null)->shouldBeCalled();
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request)->shouldBeCalled();

        $session->set(Argument::cetera())->shouldNotBeCalled();
        $session->remove(Argument::any())->shouldNotBeCalled();

        $this->populate($event);
    }

    public function it_removes_session_if_tag_bag_is_empty(TagBagInterface $tagBag, FinishRequestEvent $event, Request $request, SessionInterface $session): void
    {
        $tagBag->count()->willReturn(0)->shouldBeCalled();
        $request->getSession()->willReturn($session);
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request);

        $session->remove($this->sessionKey)->shouldBeCalled();

        $this->populate($event);
    }

    public function it_sets_session(TagBagInterface $tagBag, FinishRequestEvent $event, Request $request, SessionInterface $session): void
    {
        $tags = ['section' => ['tag1']];

        $tagBag->count()->willReturn(1)->shouldBeCalled();
        $tagBag->all()->willReturn($tags)->shouldBeCalled();
        $request->getSession()->willReturn($session)->shouldBeCalled();
        $event->isMasterRequest()->willReturn(true);
        $event->getRequest()->willReturn($request)->shouldBeCalled();

        $session->set($this->sessionKey, $tags)->shouldBeCalled();

        $this->populate($event);
    }
}
