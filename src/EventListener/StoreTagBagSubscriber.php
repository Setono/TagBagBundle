<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class StoreTagBagSubscriber implements EventSubscriberInterface
{
    public function __construct(private readonly TagBagInterface $tagBag)
    {
    }

    public static function getSubscribedEvents(): array
    {
        /*
         * The priority needs to be higher than Symfony\Component\HttpKernel\EventListener\SessionListener
         * which is -1000, but still lower than 0 so that people can listen to the response event without
         * worrying about priorities
         */
        return [
            KernelEvents::RESPONSE => ['onKernelResponse', -900],
        ];
    }

    public function onKernelResponse(ResponseEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $this->tagBag->store();
    }
}
