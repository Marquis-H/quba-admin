<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\IdleMessage;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;

class IdleMessageController extends AbstractApiController
{
    /**
     * 问答列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $params = $request->query->all();
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        CommonTools::checkParams($params, ['id']); // 商品id

        $common = $this->get(CommonService::class);
        $idleMessages = $em->getRepository('CommonBundle:IdleMessage')->findBy(['IdleApplication' => $params['id']], ["createdAt" => 'desc']);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($idleMessages));
    }

    /**
     * 创建问答
     * @Route("/create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     */
    public function createMessage(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'comment', 'type', 'isReply']);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $idleMessage = new IdleMessage();
        $idleMessage->setIsReply(false);
        if ($params['type'] == 'sale' && $params['isReply'] == true) {
            $idleMessage = $em->getRepository('CommonBundle:IdleMessage')->find($params['id']);
        }
        try {
            switch ($params['type']) {
                case 'buy':
                    $idleMessage->setIsReply(true);
                    $idleMessage->setBuyComment($params['comment']);
                    $idleMessage->setBuyCommentAt(new \DateTime());
                    $idleMessage->setBuyProfile($profile);
                    $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->find($params['id']);
                    $idleMessage->setIdleApplication($idleApplication);
                    break;
                case 'sale':
                    $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->find($params['id']);
                    $idleMessage->setIdleApplication($idleApplication);
                    $idleMessage->setSaleComment($params['comment']);
                    $idleMessage->setSaleCommentAt(new \DateTime());
                    $idleMessage->setSaleProfile($profile);
                    break;
            }

            $em->persist($idleMessage);
            $em->flush();

            return $this->createSuccessJSONResponse('success');
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }
    }
}
