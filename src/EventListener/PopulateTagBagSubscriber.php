<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateTagBagSubscriber implements EventSubscriberInterface
{
    /**
     * @var TagBagInterface
     */
    private $tagBag;

    /**
     * @var string
     */
    private $sessionKey;

    public function __construct(TagBagInterface $tagBag, string $sessionKey)
    {
        $this->tagBag = $tagBag;
        $this->sessionKey = $sessionKey;
    }

    public static function getSubscribedEvents(): array
    {
        /*
         * The priority needs to be lower than Symfony\Component\HttpKernel\EventListener\SessionListener
         * which is 128, but still higher than 0 so that people can listen to the request event without
         * worrying about priorities
         */
        return [
            KernelEvents::REQUEST => [['onKernelRequest', 100]],
        ];
    }

    public function onKernelRequest(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        $session = $request->getSession();
        if (null === $session) {
            return;
        }

        if (!$session->has($this->sessionKey)) {
            return;
        }

        $this->tagBag->initialize($session->get($this->sessionKey, []));
    }
}
