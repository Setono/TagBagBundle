<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\TagBag;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * This class will return the tag bag. The reason why we have to do it this is because
 * Symfony first starts the session when `getBag()` is called on the session service.
 * Using a service factory we are sure that people can autowire the TagBagInterface.
 */
class ServiceFactory
{
    public static function create(SessionInterface $session): TagBagInterface
    {
        /** @var TagBagInterface $tagBag */
        $tagBag = $session->getBag(TagBag::NAME);

        return $tagBag;
    }
}
