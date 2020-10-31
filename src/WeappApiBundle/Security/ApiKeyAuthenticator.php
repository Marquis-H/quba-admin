<?php


namespace WeappApiBundle\Security;

use CommonBundle\Entity\WeappUserApiKey;
use weappApiBundle\Annotation\Anonymous;
use WeappApiBundle\Constants\Common;
use WeappApiBundle\Exceptions\ApiKeyNotFoundException;
use WeappApiBundle\Exceptions\BadCredentialsException;
use CommonBundle\Helpers\CommonTools;
use Doctrine\Common\Annotations\Reader;
use Symfony\Bridge\Doctrine\RegistryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\PreAuthenticatedToken;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationFailureHandlerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Http\Authentication\SimplePreAuthenticatorInterface;

class ApiKeyAuthenticator implements SimplePreAuthenticatorInterface, AuthenticationSuccessHandlerInterface, AuthenticationFailureHandlerInterface
{
    /** @var RegistryInterface */
    protected $doctrine;

    /** @var Reader */
    protected $annotationReader;

    /**
     * ApiKeyAuthenticator constructor.
     * @param RegistryInterface $doctrine
     * @param Reader $annotationReader
     */
    public function __construct(RegistryInterface $doctrine, Reader $annotationReader)
    {
        $this->doctrine = $doctrine;
        $this->annotationReader = $annotationReader;
    }

    /**
     * @param Request $request
     * @param $providerKey
     * @return PreAuthenticatedToken
     * @throws \ReflectionException
     */
    public function createToken(Request $request, $providerKey)
    {
        $apiKey = $request->headers->get(Common::API_KEY);
        $controller = $request->attributes->get('_controller');
        if (false === strpos($controller, '::')) {
            list($controllerClass, $controllerMethod) = explode(':', $controller, 2);
        } else {
            list($controllerClass, $controllerMethod) = explode('::', $controller, 2);
        }
        $reflectionController = new \ReflectionClass($controllerClass);
        $reflectionMethod = $reflectionController->getMethod($controllerMethod);

        do {
            if ($this->annotationReader->getClassAnnotation($reflectionController, Anonymous::class) instanceof Anonymous) {
                break;
            }
            if ($this->annotationReader->getMethodAnnotation($reflectionMethod, Anonymous::class) instanceof Anonymous) {
                break;
            }
            if (is_null($apiKey)) {
                throw new BadCredentialsException();
            }
            break;
        } while (1);
        return new PreAuthenticatedToken('anon.', $apiKey, $providerKey);
    }

    /**
     * @param TokenInterface $token
     * @param UserProviderInterface $userProvider
     * @param $providerKey
     * @return PreAuthenticatedToken|TokenInterface
     */
    public function authenticateToken(TokenInterface $token, UserProviderInterface $userProvider, $providerKey)
    {
        if (!$userProvider instanceof ApiKeyUserProvider) {
            throw new \InvalidArgumentException(
                sprintf(
                    'The user provider must be an instance of ApiKeyUserProvider (%s was given).',
                    get_class($userProvider)
                )
            );
        }
        $apiKey = $token->getCredentials();
        if (is_null($apiKey)) {
            return $token;
        }
        $user = $userProvider->getUserByApiKey($apiKey);
        if (is_null($user)) {
            throw new ApiKeyNotFoundException();
        }
        $token = new PreAuthenticatedToken(
            $user,
            $apiKey,
            $providerKey,
            ['ROLE_API']
        );
        return $token;
    }

    /**
     * @param TokenInterface $token
     * @param $providerKey
     * @return bool
     */
    public function supportsToken(TokenInterface $token, $providerKey)
    {
        return $token instanceof PreAuthenticatedToken && $token->getProviderKey() === $providerKey;
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationFailure(Request $request, AuthenticationException $exception)
    {
        return new JsonResponse([
            'code' => $exception->getCode(),
            'message' => $exception->getMessage()
        ], 401);
    }

    /**
     * {@inheritDoc}
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        try {
            $em = $this->doctrine->getEntityManager();
            $apiKey = $request->headers->get(Common::API_KEY);
            $entity = $em->getRepository('CommonBundle:WeappUserApiKey')->findOneByApiKey($apiKey);
            if ($entity instanceof WeappUserApiKey) {
                $entity->setLastRequestedAt(new \DateTime());
                $entity->setLastRequestedIp(CommonTools::getRealIp());
                $em->flush();
            }
        } catch (\Exception $e) {
        }
    }
}
