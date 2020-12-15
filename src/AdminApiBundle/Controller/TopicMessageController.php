<?php


namespace AdminApiBundle\Controller;


use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class TopicMessageController extends AbstractApiController
{
    /**
     * 删除
     * @Route("/{id}/delete", name="admin.topic_message.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        /** @var EntityManager $em */
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:TopicComment');
        $topicComment = $repo->findOneBy(['id' => $id]);
        if ($topicComment === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($topicComment);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }
}
