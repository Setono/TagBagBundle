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
        return [
            KernelEvents::REQUEST => [['populate', 1024]],
        ];
    }

    public function populate(GetResponseEvent $event): void
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $request = $event->getRequest();

        if ($request->isXmlHttpRequest()) {
            return;
        }

        $session = $request->getSession();
        if (null === $session) {
            return;
        }

        if (!$session->isStarted()) {
            return;
        }

        if (!$session->has($this->sessionKey)) {
            return;
        }

        $this->tagBag->initialize($session->get($this->sessionKey, []));
    }
}
