<?php

declare(strict_types=1);

namespace Setono\TagBagBundle\Storage;

use Setono\TagBag\Storage\StorageInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Webmozart\Assert\Assert;

final class SessionStorage implements StorageInterface
{
    /** @var SessionInterface|RequestStack */
    private $session;

    /**
     * @param SessionInterface|RequestStack $session
     */
    public function __construct($session)
    {
        if ($session instanceof SessionInterface) {
            trigger_deprecation('setono/tag-bag-bundle', '2.3', 'Passing a SessionInterface to the constructor is deprecated, pass a RequestStack instead');
        }

        $this->session = $session;
    }

    public function store(string $data): void
    {
        $this->getSession()->set(self::DATA_KEY, $data);
    }

    public function restore(): ?string
    {
        $data = $this->getSession()->get(self::DATA_KEY);
        Assert::nullOrString($data);

        return $data;
    }

    public function remove(): void
    {
        $this->getSession()->remove(self::DATA_KEY);
    }

    private function getSession(): SessionInterface
    {
        if ($this->session instanceof SessionInterface) {
            return $this->session;
        }

        $request = $this->session->getMainRequest();
        Assert::notNull($request);

        $session = $request->getSession();
        Assert::isInstanceOf($session, SessionInterface::class);

        return $session;
    }
}
