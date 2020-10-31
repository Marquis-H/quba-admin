<?php
/**
 * ApiKeyNotFoundException.php
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @author      Nicky <lib.work@qq.com>
 * @copyright   @2020 WIZ TECHNOLOGY
 * @date        <2020-06-07>
 * @link        http://wizmacau.com
 * @link        http://raoliping.cn
 */

namespace WeappApiBundle\Exceptions;

use WeappApiBundle\Constants\ApiCode;
use Symfony\Component\Security\Core\Exception\AuthenticationException;

/**
 * Class ApiKeyNotFoundException
 * @package WeappApiBundle\Exceptions
 */
final class ApiKeyNotFoundException extends AuthenticationException
{
    /**
     * ApiKeyNotFoundException constructor.
     */
    public function __construct()
    {
        parent::__construct(ApiCode::getMessage(ApiCode::API_KEY_INVALID), ApiCode::API_KEY_INVALID);
    }
}
