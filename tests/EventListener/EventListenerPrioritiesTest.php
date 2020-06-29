<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Tests\EventListener;

use PHPUnit\Framework\TestCase;
use Setono\TagBagBundle\EventListener\RestoreTagBagSubscriber;
use Setono\TagBagBundle\EventListener\StoreTagBagSubscriber;
use Symfony\Component\HttpKernel\EventListener\SessionListener;
use Symfony\Component\HttpKernel\KernelEvents;

final class EventListenerPrioritiesTest extends TestCase
{
    /**
     * @test
     */
    public function priorities_are_correct(): void
    {
        $sessionListenerEvents = SessionListener::getSubscribedEvents();
        $populateTagBagEvents = RestoreTagBagSubscriber::getSubscribedEvents();
        $populateSessionEvents = StoreTagBagSubscriber::getSubscribedEvents();

        $sessionListenerResponsePriority = $sessionListenerEvents[KernelEvents::RESPONSE][1];
        $sessionListenerRequestPriority = $sessionListenerEvents[KernelEvents::REQUEST][1];

        $this->assertIsInt($sessionListenerResponsePriority);
        $this->assertIsInt($sessionListenerRequestPriority);

        $responsePriority = $populateSessionEvents[KernelEvents::RESPONSE][1];
        $requestPriority = $populateTagBagEvents[KernelEvents::REQUEST][1];

        $this->assertIsInt($responsePriority);
        $this->assertIsInt($requestPriority);

        $this->assertLessThan($sessionListenerRequestPriority, $requestPriority);
        $this->assertGreaterThan($sessionListenerResponsePriority, $responsePriority);
    }
}
