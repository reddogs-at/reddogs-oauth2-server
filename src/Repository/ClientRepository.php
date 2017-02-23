<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\ClientRepositoryInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\Client;
use Zend\Crypt\Password\Bcrypt;


class ClientRepository implements ClientRepositoryInterface
{
    use EntityManagerAwareTrait;

    /**
     * Bcrypt
     *
     * @var Bcrypt
     */
    private $bcrypt;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     * @param Bcrypt $bcrypt
     */
    public function __construct(EntityManager $entityManager, Bcrypt $bcrypt)
    {
        $this->setEntityManager($entityManager);
        $this->bcrypt = $bcrypt;
    }

    /**
     * Get bcrypt
     *
     * @return Bcrypt
     */
    public function getBcrypt() : Bcrypt
    {
        return $this->bcrypt;
    }

    /**
     * Get client
     *
     * {@inheritdoc}
     *
     * @see \League\OAuth2\Server\Repositories\ClientRepositoryInterface::getClientEntity()
     */
    public function getClientEntity($clientIdentifier, $grantType, $clientSecret = null, $mustValidateSecret = true)
    {
        $client = $this->getEntityManager()->getRepository(Client::class)->findOneBy(['identifier' => $clientIdentifier]);
        if (null === $client) {
            return;
        }

        if (($this->isValidGrantType($client, $grantType)) and ($this->isValidSecret($client, $clientSecret, $mustValidateSecret))) {
            return $client;
        }
    }

    /**
     * Is valid grant type
     *
     * @param Client $client
     * @param string $grantType
     * @return boolean
     */
    private function isValidGrantType(Client $client, string $grantType)
    {
        if (in_array($grantType, $client->getGrantTypes())) {
            return true;
        }
        return false;
    }

    /**
     * Is valid secret
     *
     * @param Client $client
     * @param string $clientSecret
     * @param bool $mustValidateSecret
     * @return boolean
     */
    private function isValidSecret(Client $client, string $clientSecret = null, bool $mustValidateSecret)
    {
        if (true === $mustValidateSecret) {
            return $this->getBcrypt()->verify($clientSecret, $client->getSecret());
        }
        return true;
    }
}