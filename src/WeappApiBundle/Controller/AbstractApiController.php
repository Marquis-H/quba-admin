<?php
/**
 * AbstractApiController.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author    jack <jack@wizmacau.com>
 * @copyright 2007-2018/1/17 WIZ TECHNOLOGY
 * @link      https://wizmacau.com
 * @link      https://lamjack.github.io
 * @link      https://github.com/lamjack
 * @version
 */

namespace WeappApiBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;


/**
 * Class AbstractApiController
 *
 * @package WeappApiBundle\Controller
 */
class AbstractApiController extends Controller
{
    /**
     * 创建操作成功JSON响应
     *
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function createSuccessJSONResponse($message = '', array $data = [])
    {
        return new JsonResponse([
            'code' => 0,
            'message' => $message,
            'data' => $data
        ], 200, [
            'Access-Control-Allow-Origin' => $this->container->getParameter('api_domain_allow'),
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Access-Control-Allow-Methods' => 'GET,HEAD,OPTIONS,POST,PUT'
        ]);
    }

    /**
     * 创建操作失败JSON响应
     *
     * @param int $code
     * @param string $message
     * @param array $data
     * @return JsonResponse
     */
    public function createFailureJSONResponse($code, $message = '', array $data = [])
    {
        return new JsonResponse([
            'code' => $code,
            'message' => $message,
            'data' => $data
        ], 200, [
            'Access-Control-Allow-Origin' => $this->container->getParameter('api_domain_allow'),
            'Access-Control-Allow-Headers' => 'Content-Type',
            'Access-Control-Allow-Methods' => 'GET,HEAD,OPTIONS,POST,PUT'
        ]);
    }

    /**
     * @param null $name
     * @return EntityManager|object
     */
    protected function getEntityManager($name = null)
    {
        return $this->get('doctrine.orm.default_entity_manager');
    }
}
