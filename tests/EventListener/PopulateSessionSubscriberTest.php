<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Setono\TagBagBundle\EventListener\PopulateSessionSubscriber;
use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateSessionSubscriberTest extends TestCase
{
    private $sessionKey = 'session_key';

    public function it_listens_to_response_event(): void
    {
        $this->assertArrayHasKey(KernelEvents::RESPONSE, PopulateSessionSubscriber::getSubscribedEvents());
    }

    /**
     * @test
     */
    public function it_does_not_set_session_request_is_not_master_request(): void
    {
        $request = $this->createMock(Request::class);
        $request->expects($this->never())->method('getSession');
        $event = $this->getEvent($request, null, HttpKernelInterface::SUB_REQUEST);

        $this->getSubscriber()->onKernelResponse($event);
    }

    /**
     * @test
     */
    public function it_removes_session_if_tag_bag_is_empty(): void
    {
        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())->method('remove');

        $request = $this->createMock(Request::class);
        $request->method('getSession')->willReturn($session);

        $tagBag = $this->createMock(TagBagInterface::class);
        $tagBag->expects($this->once())->method('count')->willReturn(0);

        $event = $this->getEvent($request);

        $this->getSubscriber($tagBag)->onKernelResponse($event);
    }

    /**
     * @test
     */
    public function it_sets_session(): void
    {
        $tags = ['section' => ['tag1']];

        $session = $this->createMock(SessionInterface::class);
        $session->expects($this->once())->method('set')->with($this->sessionKey, $tags);

        $request = $this->createMock(Request::class);
        $request->method('getSession')->willReturn($session);

        $tagBag = $this->createMock(TagBagInterface::class);
        $tagBag->expects($this->once())->method('count')->willReturn(1);
        $tagBag->expects($this->once())->method('all')->willReturn($tags);

        $event = $this->getEvent($request);

        $this->getSubscriber($tagBag)->onKernelResponse($event);
    }

    private function getEvent(Request $request = null, Response $response = null, int $requestType = HttpKernelInterface::MASTER_REQUEST): ResponseEvent
    {
        return new ResponseEvent(
            $this->createMock(HttpKernelInterface::class),
            $request ?: new Request(),
            $requestType,
            $response ?: new Response()
        );
    }

    private function getSubscriber(TagBagInterface $tagBag = null): PopulateSessionSubscriber
    {
        return new PopulateSessionSubscriber($tagBag ?: $this->createMock(TagBagInterface::class), $this->sessionKey);
    }
}
