<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TagBag;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ServiceFactory
{
    public static function create(SessionInterface $session): TagBagInterface
    {
        /** @var TagBagInterface $tagBag */
        $tagBag = $session->getBag('tags');

        return $tagBag;
    }
}
