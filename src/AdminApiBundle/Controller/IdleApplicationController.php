<?php


namespace AdminApiBundle\Controller;


use CommonBundle\Entity\IdleApplication;
use CommonBundle\Exception\ApiException;
use CommonBundle\Helpers\CommonHelper;
use CommonBundle\Helpers\CommonTools;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class IdleApplicationController extends AbstractApiController
{
    /**
     * @Route("/list", name="admin.idle_application.list", methods={"GET"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     */
    public function list(Request $request)
    {
        $common = $this->container->get(CommonHelper::class);
        $repo = $this->getEntityManager()->getRepository('CommonBundle:IdleApplication');

        $queryBuild = $repo->getQueryBuilder();
        $result = $common->filterPagination($request->query->get('filters'), $request->query->get('currentPage'), $request->query->get('perPage'), $queryBuild, IdleApplication::class);

        return $this->createSuccessJSONResponse('success', $result);
    }

    /**
     * 删除
     * @Route("/{id}/delete", name="admin.idle_application.delete", methods={"POST"})
     *
     * @param $id
     * @return JsonResponse
     */
    public function delete($id)
    {
        $em = $this->get('doctrine.orm.default_entity_manager');
        $repo = $em->getRepository('CommonBundle:IdleApplication');
        $idleApplication = $repo->findOneBy(['id' => $id]);
        if ($idleApplication === null) {
            return self::createFailureJSONResponse('fail');
        }

        try {
            $em->remove($idleApplication);
            $em->flush();
        } catch (\Exception $e) {
            $em->rollback();
        }

        return self::createSuccessJSONResponse('success', []);
    }

    /**
     * @Route("/change_top", name="admin.idle_application.change_top", methods={"POST"})
     *
     * @param Request $request
     * @return JsonResponse
     * @throws ApiException
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function changeTop(Request $request)
    {
        $params = $request->request->all();
        CommonTools::checkParams($params, ['id', 'isTop']);

        $em = $this->getEntityManager();
        $idleApplication = $em->getRepository('CommonBundle:IdleApplication')->find($params['id']);
        if ($idleApplication == null) {
            return $this->createFailureJSONResponse(-1, '没有记录');
        }

        $idleApplication->setTopAt($params['isTop'] ? new \DateTime() : null);
        $em->persist($idleApplication);
        $em->flush();

        return $this->createSuccessJSONResponse('success');
    }
}
