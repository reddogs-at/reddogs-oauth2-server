<?php
/**
 * Reddogs (https://github.com/reddogs-at)
 *
 * @see https://github.com/reddogs-at/reddogs-oauth2-server for the canonical source repository
 * @license https://github.com/reddogs-at/reddogs-oauth2-server/blob/master/LICENSE MIT License
 */
declare(strict_types = 1);
namespace Reddogs\OAuth2\Server\Repository;

use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use Reddogs\Doctrine\ORM\EntityManagerAwareTrait;
use Doctrine\ORM\EntityManager;
use Reddogs\OAuth2\Server\Entity\AccessToken;

class AccessTokenRepository implements AccessTokenRepositoryInterface
{
    use EntityManagerAwareTrait;

    /**
     * Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->setEntityManager($entityManager);
    }

    /**
     * Get new token
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface::getNewToken()
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = new AccessToken(null, $clientEntity, $userIdentifier);
        foreach ($scopes as $scope) {
            $accessToken->addScope($scope);
        }
        return $accessToken;
    }

    /**
     * Persist new access token
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface::persistNewAccessToken()
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $em = $this->getEntityManager();
        $em->persist($accessTokenEntity);
        $em->flush($accessTokenEntity);
    }

    /**
     * Revoke access token
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface::revokeAccessToken()
     */
    public function revokeAccessToken($tokenId)
    {
        $em = $this->getEntityManager();
        $token = $this->getEntityManager()->getRepository(AccessToken::class)->findOneBy(['identifier' => $tokenId]);
        $em->remove($token);
        $em->flush($token);
    }

    /**
     * Is access token revoked
     *
     * {@inheritDoc}
     * @see \League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface::isAccessTokenRevoked()
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return (null === $this->getEntityManager()->getRepository(AccessToken::class)->findOneBy(['identifier' => $tokenId]));
    }
}