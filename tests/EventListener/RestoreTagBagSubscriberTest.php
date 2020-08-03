<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Prophecy\PhpUnit\ProphecyTrait;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\EventListener\RestoreTagBagSubscriber;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\EventListener\SessionListener;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @covers \Setono\TagBagBundle\EventListener\RestoreTagBagSubscriber
 */
final class RestoreTagBagSubscriberTest extends TestCase
{
    use ProphecyTrait;

    /**
     * @test
     */
    public function it_restores(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->restore()->shouldBeCalled();

        $event = $this->prophesize(RequestEvent::class);
        $event->isMasterRequest()->willReturn(true);

        $subscriber = new RestoreTagBagSubscriber($tagBag->reveal());
        $subscriber->onKernelRequest($event->reveal());
    }

    /**
     * @test
     */
    public function it_does_not_restore_when_the_request_is_not_a_master_request(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->restore()->shouldNotBeCalled();

        $event = $this->prophesize(RequestEvent::class);
        $event->isMasterRequest()->willReturn(false);

        $subscriber = new RestoreTagBagSubscriber($tagBag->reveal());
        $subscriber->onKernelRequest($event->reveal());
    }

    /**
     * @test
     */
    public function it_listens_to_the_correct_event(): void
    {
        $subscribedEvents = RestoreTagBagSubscriber::getSubscribedEvents();
        $this->assertCount(1, $subscribedEvents);
        $this->assertTrue(isset($subscribedEvents[KernelEvents::REQUEST]));
    }

    /**
     * @test
     */
    public function it_has_the_correct_priority(): void
    {
        $priority = RestoreTagBagSubscriber::getSubscribedEvents()[KernelEvents::REQUEST][1];
        $sessionListenerPriority = SessionListener::getSubscribedEvents()[KernelEvents::REQUEST][1];

        $this->assertLessThan($sessionListenerPriority, $priority);
    }
}
