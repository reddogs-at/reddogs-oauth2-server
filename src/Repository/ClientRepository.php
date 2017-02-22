<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\Oauth2\Server;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;


class ClientRepository implements ClientRepositoryInterface
{

    /**
     * Get client
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\ClientRepositoryInterface::getClientEntity()
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true): ClientEntityInterface
    {

    }
}