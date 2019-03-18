<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateSessionSubscriber implements EventSubscriberInterface
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
            KernelEvents::FINISH_REQUEST => 'populate',
        ];
    }

    public function populate(FinishRequestEvent $event): void
    {
        if(!$event->isMasterRequest()) {
            return;
        }

        $session = $event->getRequest()->getSession();
        if (null === $session) {
            return;
        }

        if ($this->tagBag->count() > 0) {
            $session->set($this->sessionKey, $this->tagBag->all());
        } else {
            $session->remove($this->sessionKey);
        }
    }
}
