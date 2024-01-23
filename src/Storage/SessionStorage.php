<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Storage;

use Setono\TagBag\Exception\StorageException;
use Setono\TagBag\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\Exception\SessionNotFoundException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

final class SessionStorage implements StorageInterface
{
    public function __construct(private readonly RequestStack $requestStack)
    {
    }

    public function store(string $data): void
    {
        $this->getSession()->set(self::DATA_KEY, $data);
    }

    public function restore(): ?string
    {
        if (!$this->getRequest()->hasPreviousSession()) {
            return null;
        }

        /** @var mixed $data */
        $data = $this->getSession()->get(self::DATA_KEY);

        return is_string($data) ? $data : null;
    }

    public function remove(): void
    {
        $session = $this->getSession();
        if (!$session->isStarted()) {
            return;
        }

        $session->remove(self::DATA_KEY);
    }

    private function getRequest(): Request
    {
        $request = $this->requestStack->getCurrentRequest();
        if (null === $request) {
            throw new StorageException('No request available. The tag bag can only be stored in a request context');
        }

        return $request;
    }

    private function getSession(): SessionInterface
    {
        try {
            return $this->requestStack->getSession();
        } catch (SessionNotFoundException $e) {
            throw new StorageException($e->getMessage(), 0, $e);
        }
    }
}
