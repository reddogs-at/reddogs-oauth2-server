<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\UserRepositoryInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\Client;
use Reddogs\OAuth2\Server\Entity\User;
use Zend\Crypt\Password\Bcrypt;

class UserRepository implements UserRepositoryInterface
{
    use EntityManagerAwareTrait;

    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    public function getUserEntityByUserCredentials($username, $password, $grantType, ClientEntityInterface $clientEntity)
    {
        $user = $this->getEntityManager()->getRepository(User::class)->findOneBy(['username' => $username]);
        if ($this->isValidPassword($user, $password)) {
            return $user;
        }
    }

    /**
     * Is valid password
     *
     * @param Client $client
     * @param string $clientSecret
     * @return boolean
     */
    private function isValidPassword(User $user, string $password)
    {
        $bcrypt = new Bcrypt();
        return $bcrypt->verify($password, $user->getPassword());
    }
}