<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateSessionSubscriber implements EventSubscriberInterface
{
    /**
     * @var TagBagInterface
     */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::RESPONSE => 'populate'
        ];
    }

    public function populate(FilterResponseEvent $event): void
    {
        $event->getRequest()->getSession()->set('test', $this->tagBag->all());
    }
}
