<?php


namespace AdminApiBundle\Controller;

use CommonBundle\Entity\Topic;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Services\TopicService;
use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\NotBlank;

class TopicController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.topic.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:Topic');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, Topic::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * @Route("/create", name="admin.topic.create", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request)
    {
        $data = $request->request->all();
        $validator = $this->get('validator');
        $collectionConstraint = new Collection([
            'title' => [
                new NotBlank()
            ],
            'content' => [
                new NotBlank()
            ],
            'category' => [
                new NotBlank()
            ],
            'isEnable' => [],
            'photos' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);

        if (count($errors) > 0) {
            return self::createFailureJSONResponse('fail', 100, $this->getErrors($errors));
        } else {
            $topicService = $this->get(TopicService::class);
            try {
                $topic = new Topic();
                /** @var Topic $topic */
                $topic = $topicService->save($topic, $data);

                $data['id'] = $topic->getId();
                $data['createdAt'] = $topic->getCreatedAt()->format('Y-m-d H:i');
                $data['like'] = $topic->getLikeNum();
                $data['views'] = $topic->getViews();
            } catch (\Exception $e) {
                return self::createFailureJSONResponse($e->getMessage());
            }
        }

        return self::createSuccessJSONResponse('success', $data);
    }

    /**
     * @Route("/{id}/update", name="admin.topic.update", methods={"POST"})
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Topic');

        $data = $request->request->all();
        $validator = $this->get('validator');
        unset($data['createdAt']);
        unset($data['like']);
        unset($data['views']);
        unset($data['publisher']);

        $collectionConstraint = new Collection([
            'id' => [],
            'title' => [
                new NotBlank()
            ],
            'content' => [
                new NotBlank()
            ],
            'category' => [
                new NotBlank()
            ],
            'isEnable' => [],
            'photos' => []
        ]);

        $errors = $validator->validate($data, $collectionConstraint);
        if (count($errors) > 0) {
            return self::createFailureJSONResponse(100, 'fail', $this->getErrors($errors));
        } else {
            $topicService = $this->get(TopicService::class);
            try {
                $topic = $repo->find($id);
                if ($topic === null) {
                    return $this->createFailureJSONResponse(-1, 'fail');
                }
                /** @var Topic $topic */
                $topic = $topicService->save($topic, $data);

                $data['id'] = $topic->getId();
                $data['createdAt'] = $topic->getCreatedAt()->format('Y-m-d H:i');
                $data['like'] = $topic->getLikeNum();
                $data['views'] = $topic->getViews();
            } catch (\Exception $e) {
                return self::createFailureJSONResponse(-1, 'fail');
            }
        }

        return $this->createSuccessJSONResponse('success', $data);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.topic.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:Topic');
        $topic = $repo->findOneBy(['id' => $id]);
        if ($topic === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($topic);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
