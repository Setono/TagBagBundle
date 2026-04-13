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
        /** @psalm-suppress InternalMethod */
        $sessionListenerEvents = SessionListener::getSubscribedEvents();
        $populateTagBagEvents = RestoreTagBagSubscriber::getSubscribedEvents();
        $populateSessionEvents = StoreTagBagSubscriber::getSubscribedEvents();

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        $sessionListenerResponsePriority = $sessionListenerEvents[KernelEvents::RESPONSE][1];

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        $sessionListenerRequestPriority = $sessionListenerEvents[KernelEvents::REQUEST][1];

        self::assertIsInt($sessionListenerResponsePriority);
        self::assertIsInt($sessionListenerRequestPriority);

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        $responsePriority = $populateSessionEvents[KernelEvents::RESPONSE][1];

        /** @psalm-suppress PossiblyUndefinedArrayOffset */
        $requestPriority = $populateTagBagEvents[KernelEvents::REQUEST][1];

        self::assertIsInt($responsePriority);
        self::assertIsInt($requestPriority);

        self::assertLessThan($sessionListenerRequestPriority, $requestPriority);
        self::assertGreaterThan($sessionListenerResponsePriority, $responsePriority);
    }
}
