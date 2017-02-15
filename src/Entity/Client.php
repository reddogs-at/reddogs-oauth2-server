<?php

declare(strict_types=1);

namespace Reddogs\OAuth2\Server\Entity;

use League\OAuth2\Server\Entities\ClientEntityInterface;

class Client implements ClientEntityInterface
{
    private $identifier;

    private $name;

    public function __construct(string $identifier = null, string $name = null)
    {
        $this->identifier = $identifier;
        $this->name = $name;
    }

    public function getIdentifier() : string
    {
        return $this->identifier;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function getRedirectUri()
    {

    }
}