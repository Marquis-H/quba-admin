<?php
/**
 * Created by PhpStorm.
 * User: dxw
 * Date: 2020/1/21
 * Time: 10:05 AM
 */

namespace CommonBundle\EventListener;

use CommonBundle\Entity\FosUser;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationFailureEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\AuthenticationSuccessEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Event\JWTDecodedEvent;
use Lexik\Bundle\JWTAuthenticationBundle\Events;
use Lexik\Bundle\JWTAuthenticationBundle\Response\JWTAuthenticationFailureResponse;
use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class JWTEventListener implements EventSubscriberInterface
{
    use ContainerAwareTrait;

    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            Events::AUTHENTICATION_SUCCESS => 'onAuthenticationSuccessResponse',
            Events::AUTHENTICATION_FAILURE => 'onAuthenticationFailureResponse',
            Events::JWT_DECODED => 'onJWTDecoded'
        ];
    }

    /**
     * @param AuthenticationSuccessEvent $event
     */
    public function onAuthenticationSuccessResponse(AuthenticationSuccessEvent $event)
    {
        $data = $event->getData();
        $data['data']['roles'] = $event->getUser()->getRoles();
        $event->setData($data);
    }

    /**
     * @param AuthenticationFailureEvent $event
     */
    public function onAuthenticationFailureResponse(AuthenticationFailureEvent $event)
    {
        $response = new JWTAuthenticationFailureResponse('Bad credentials', 200);
        $event->setResponse($response);
    }

    /**
     * @param JWTDecodedEvent $event
     */
    public function onJWTDecoded(JWTDecodedEvent $event)
    {
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $payload = $event->getPayload();
        // roles
        $roles = $payload['roles'];
        $isApp = in_array('app', $roles);

        if ($isApp) {
            $userRepo = $em->getRepository('CommonBundle:WeappUser');
            if (isset($payload['openId'])) {
                $user = $userRepo->findOneBy(['openId' => $payload['openId']]);
                if (!$user) {
                    $event->markAsInvalid();
                }
            }
        } else {
            $backendUserRepo = $em->getRepository('CommonBundle:FosUser');
            /** @var FosUser $backendUser */
            $backendUser = $backendUserRepo->findOneBy(['username' => $payload['username']]);
            if (!$backendUser) {
                $event->markAsInvalid();
            }
        }
    }
}
