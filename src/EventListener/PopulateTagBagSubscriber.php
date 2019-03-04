<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\EventListener;

use Setono\TagBagBundle\TagBag\TagBagInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final class PopulateTagBagSubscriber implements EventSubscriberInterface
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
            KernelEvents::REQUEST => 'populate'
        ];
    }

    public function populate(GetResponseEvent $event): void
    {
        $arr = $event->getRequest()->getSession()->get('test');

        $this->tagBag->initialize($arr);
    }
}
