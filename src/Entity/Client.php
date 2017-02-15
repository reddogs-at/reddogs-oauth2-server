<?php

declare(strict_types=1);

namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class Client implements ClientEntityInterface
{
    private $identifier;

    public function __construct(string $identifier = null)
    {
        $this->identifier = $identifier;
    }

    public function getIdentifier()
    {
        return $this->identifier;
    }

    public function getName()
    {

    }

    public function getRedirectUri()
    {

    }
}