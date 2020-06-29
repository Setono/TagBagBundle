<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Setono\TagBag\TagBagInterface;
use Setono\TagBagBundle\EventListener\StoreTagBagSubscriber;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\EventListener\SessionListener;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @covers \Setono\TagBagBundle\EventListener\StoreTagBagSubscriber
 */
final class StoreTagBagSubscriberTest extends TestCase
{
    /**
     * @test
     */
    public function it_stores(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->store()->shouldBeCalled();

        $subscriber = new StoreTagBagSubscriber($tagBag->reveal());
        $subscriber->onKernelResponse($this->getResponseEvent(true));
    }

    /**
     * @test
     */
    public function it_does_not_store_when_the_request_is_not_a_master_request(): void
    {
        $tagBag = $this->prophesize(TagBagInterface::class);
        $tagBag->store()->shouldNotBeCalled();

        $subscriber = new StoreTagBagSubscriber($tagBag->reveal());
        $subscriber->onKernelResponse($this->getResponseEvent(false));
    }

    /**
     * @test
     */
    public function it_listens_to_the_correct_event(): void
    {
        $subscribedEvents = StoreTagBagSubscriber::getSubscribedEvents();
        $this->assertCount(1, $subscribedEvents);
        $this->assertTrue(isset($subscribedEvents[KernelEvents::RESPONSE]));
    }

    /**
     * @test
     */
    public function it_has_the_correct_priority(): void
    {
        $priority = StoreTagBagSubscriber::getSubscribedEvents()[KernelEvents::RESPONSE][1];
        $sessionListenerPriority = SessionListener::getSubscribedEvents()[KernelEvents::RESPONSE][1];

        $this->assertGreaterThan($sessionListenerPriority, $priority);
    }

    /**
     * @return ResponseEvent|MockObject
     */
    private function getResponseEvent(bool $masterRequest): ResponseEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->createMock(Request::class);
        $response = $this->createMock(Response::class);

        return new ResponseEvent($kernel, $request, $masterRequest ? HttpKernelInterface::MASTER_REQUEST : HttpKernelInterface::SUB_REQUEST, $response);
    }
}
