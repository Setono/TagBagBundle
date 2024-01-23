<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class RestoreTagBagSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly TagBagInterface $tagBag)
    {
    }

    public static function getSubscribedEvents(): array
    {
        /*
         * The priority needs to be lower than Symfony\Bundle\SecurityBundle\EventListener\FirewallListener
         * which is 8, but still higher than 0 so that people can listen to the request event without
         * worrying about priorities
         */
        return [
            KernelEvents::REQUEST => ['onKernelRequest', 7],
        ];
    }

    public function onKernelRequest(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->tagBag->restore();
    }
}
