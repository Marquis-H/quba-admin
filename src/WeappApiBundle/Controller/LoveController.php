<?php


namespace WeappApiBundle\Controller;

use CommonBundle\Constants\ApiCode;
use CommonBundle\Entity\SayLoveMessage;
use CommonBundle\Entity\SayLoveMessageComment;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\Routing\Annotation\Route;

class LoveController extends AbstractApiController
{
    /**
     * 列表
     * @Route("/list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function loveList(Request $request)
    {
        $params = $request->query->all(); // profile id
        $em = $this->get('doctrine.orm.default_entity_manager');
        $common = $this->get(CommonService::class);
        $sayLoves = $em->getRepository('CommonBundle:SayLoveMessage')->findBy([], ["createdAt" => 'desc']);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($sayLoves));
    }

    /**
     * 保存
     * @Route("/create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function createLove(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new ApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }
        $params = $request->request->all();
        $accessor = PropertyAccess::createPropertyAccessor();
        CommonTools::checkParams($params, ['nickname', 'name', 'taName', 'content']);

        $em = $this->get('doctrine.orm.default_entity_manager');
        $love = new SayLoveMessage();
        try {
            $love->setSelfNickname($params['nickname']);
            $love->setSelfName($params['name']);
            $love->setSelfGender($accessor->getValue($params, "[gender]"));
            $love->setSheName($params['taName']);
            $love->setSheGender($accessor->getValue($params, "[taGender]"));
            $love->setContent($params['content']);
            $love->setProfile($profile);
            $em->persist($love);
            $em->flush();

            return $this->createSuccessJSONResponse('success');
        } catch (\Exception $e) {
            return $this->createFailureJSONResponse(-1, $e->getMessage());
        }
    }

    /**
     * @Route("/like", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function like(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id']);

        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var SayLoveMessage $sayLove */
        $sayLove = $em->getRepository('CommonBundle:SayLoveMessage')->find($params['id']);

        $sayLove->setLike($sayLove->getLike() + 1);
        $em->persist($sayLove);
        $em->flush();

        return $this->createSuccessJSONResponse('success');
    }

    /**
     * @Route("/guess", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function guess(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'isGuess']);

        $em = $this->get('doctrine.orm.default_entity_manager');
        /** @var SayLoveMessage $sayLove */
        $sayLove = $em->getRepository('CommonBundle:SayLoveMessage')->find($params['id']);

        if ($params['isGuess']) { // 猜中
            $sayLove->setGuessRight($sayLove->getGuessRight() + 1);
        }
        $sayLove->setGuess($sayLove->getGuess() + 1);
        $em->persist($sayLove);
        $em->flush();

        return $this->createSuccessJSONResponse('success');
    }

    /**
     * @Route("/comment", methods={"GET","POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function comment(Request $request){
        $params = $request->query->all();
//        CommonTools::checkParams($params, ['id']);
        $common = $this->get(CommonService::class);

        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        if($request->getMethod() == 'POST'){
            $params = $request->request->all();
            CommonTools::checkParams($params, ['id', 'comment']);
            $sayMessage = $em->getRepository('CommonBundle:SayLoveMessage')->find($params['id']);

            $sayMessageComment = new SayLoveMessageComment();
            $sayMessageComment->setComment($params['comment']);
            $sayMessageComment->setSayLoveMessage($sayMessage);

            $em->persist($sayMessageComment);
            $em->flush();
        }
        $sayMessages = $em->getRepository('CommonBundle:SayLoveMessageComment')->findBy(['SayLoveMessage' => $params['id']], ['createdAt' => 'asc']);

        return $this->createSuccessJSONResponse('success', $common->toDataModel($sayMessages));
    }
}
