<?php
namespace WeappApiBundle\Security;

use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Entity\WeappUserApiKey;
use CommonBundle\Helpers\CommonTools;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

/**
 * Class ApiKeyUserProvider
 * @package WeappApiBundle\Security
 */
class ApiKeyUserProvider implements UserProviderInterface, ApiKeyUserProviderInterface
{
    /**
     * @var RegistryInterface
     */
    protected $doctrine;

    /**
     * ApiKeyUserProvider constructor.
     * @param RegistryInterface $doctrine
     */
    public function __construct(RegistryInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    /**
     * @param WeappUser $account
     * @return string
     * @throws WeappApiException
     */
    public function createApiKey(WeappUser $account)
    {
        try {
            $account->setLastLoginAt(new \DateTime());
            $account->setLastLoginIp(CommonTools::getRealIp());
            $login = $account->getLastLoginAt() ? $account->getLastLoginAt()->getTimestamp() : time();
            $apiKey = uniqid() . '_TK_' . $account->getUsername() . '_TK_' . $login . '_TK_' . (time() + 60 * 86400);
            $token = md5(md5($apiKey));
            // 存入DB
            $apiRequest = new WeappUserApiKey();
            $apiRequest->setWeappUser($account);
            $apiRequest->setApiKey($token);
            $apiRequest->setLastRequestedAt(new \DateTime());
            $apiRequest->setLastRequestedIp(CommonTools::getRealIp());
            $em = $this->getEntityManager();
            $em->persist($account);
            $em->persist($apiRequest);
            $em->flush();

            //$conn = $em->getConnection();
            //$conn->delete('go_provider_api_key', ['provider_id' => $apiRequest->getProvider()->getId()]);
            return $token;
        } catch (\Exception $e) {
            throw new WeappApiException($e->getMessage(), ApiCode::DATA_ERROR);
        }
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $em = $this->getEntityManager();
        $user = $em->getRepository('CommonBundle:WeappUser')->findOneByUsername($username);
        if (is_null($user))
            throw new UsernameNotFoundException();
        return $user;
    }

    /**
     * {@inheritDoc}
     */
    public function getUserByApiKey(string $apiKey)
    {
        $em = $this->getEntityManager();
        $entity = $em->getRepository('CommonBundle:WeappUserApiKey')->findOneByApiKey($apiKey);
        if ($entity instanceof WeappUserApiKey) {
            return $entity->getWeappUser();
        }
        return null;
    }

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        throw new UnsupportedUserException();
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return WeappUser::class === $class;
    }

    /**
     * @return EntityManager
     */
    protected function getEntityManager()
    {
        return $this->doctrine->getEntityManager();
    }
}
