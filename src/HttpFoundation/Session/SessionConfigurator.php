<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\HttpFoundation\Session;

use Setono\TagBagBundle\HttpFoundation\Session\Tag\TagBagInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionConfigurator implements SessionConfiguratorInterface
{
    /**
     * @var TagBagInterface
     */
    private $tagBag;

    public function __construct(TagBagInterface $tagBag)
    {
        $this->tagBag = $tagBag;
    }

    /**
     * {@inheritdoc}
     */
    public function configure(SessionInterface $session): void
    {
        $session->registerBag($this->tagBag);
    }
}
