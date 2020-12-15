<?php


namespace WeappApiBundle\Controller;


use CommonBundle\Entity\Topic;
use CommonBundle\Entity\TopicComment;
use CommonBundle\Entity\WeappUser;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonTools;
use CommonBundle\Services\CommonService;
use CommonBundle\Services\WechatService;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use EasyWeChat\Kernel\Exceptions\InvalidConfigException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use WeappApiBundle\Annotation\Anonymous;
use WeappApiBundle\Constants\ApiCode;
use WeappApiBundle\Exceptions\WeappApiException;

class TopicController extends AbstractApiController
{
    /**
     * 热门话题
     * @Route("/hot", methods={"GET"})
     * @Anonymous()
     * @param Request $request
     * @return JsonResponse
     */
    public function hotTopic(Request $request)
    {
        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        /** @var Topic $hotTopic */
        $hotTopic = $em->getRepository('CommonBundle:Topic')->findOneBy(['category' => 'hot'], ['createdAt' => 'desc']);

        $commonService = $this->container->get(CommonService::class);
        $data = $commonService->toDataModel($hotTopic);
        if (empty($data['publisher'])) {
            $data['publisher']['nickname'] = "有寻";
            $data['publisher']['avatar'] = "https://youxun.qidorg.com/img/logo.10d12101.png";
        }
        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * 新增评论
     * @Route("/add_comment", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws WeappApiException
     * @throws ORMException
     * @throws OptimisticLockException
     * @throws InvalidConfigException
     */
    public function addComment(Request $request)
    {
        /** @var WeappUser $user */
        $user = $this->getUser();
        $profile = $user->getWeappUserProfile();

        if (!$profile) {
            throw new WeappApiException('please finish your profile first', ApiCode::PROFILE_NOT_FOUND);
        }

        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'comment']);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $topic = $em->getRepository('CommonBundle:Topic')->findOneBy(['id' => $params['id']]);

        if ($topic == null) {
            throw new WeappApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        // 检查comment
        $wechatService = $this->get(WechatService::class);
        $app = $wechatService->getApplication();
        $result = $app->content_security->checkText($params['comment']);
        if($result['errcode'] != 0){
            throw new WeappApiException('内容违规', ApiCode::DATA_ERROR);
        }
        $topicComment = new TopicComment();
        $topicComment->setComment($params['comment']);
        $topicComment->setTopic($topic);
        $topicComment->setProfile($profile);

        $em->persist($topicComment);
        $em->flush();

        return $this->createSuccessJSONResponse();
    }

    /**
     * 新增查看
     * @Route("/add_view", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addView(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id']);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        $topic = $em->getRepository('CommonBundle:Topic')->findOneBy(['id' => $params['id']]);

        if ($topic == null) {
            throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
        }

        $topic->setViews($topic->getViews() + 1);
        $em->persist($topic);
        $em->flush();

        return $this->createSuccessJSONResponse();
    }

    /**
     * 新增LIKE
     * @Route("/add_like", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function addLike(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'type']);

        /** @var EntityManager $em */
        $em = $this->container->get('doctrine.orm.default_entity_manager');
        switch ($params['type']) {
            case 'topic':
                $topic = $em->getRepository('CommonBundle:Topic')->findOneBy(['id' => $params['id']]);

                if ($topic == null) {
                    throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
                }

                $topic->setLikeNum($topic->getLikeNum() + 1);
                $em->persist($topic);
                break;
            case 'comment':
                $topicComment = $em->getRepository('CommonBundle:TopicComment')->findOneBy(['id' => $params['id']]);

                if ($topicComment == null) {
                    throw new ApiException('记录不存在', ApiCode::DATA_NOT_FOUND);
                }

                $topicComment->setLikeNum($topicComment->getLikeNum() + 1);
                $em->persist($topicComment);
                break;
        }

        $em->flush();
        return $this->createSuccessJSONResponse();
    }
}
