<?php
/**
 * BadCredentialsException.php
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
 * Class BadCredentialsException
 * @package WeappApiBundle\Exceptions
 */
final class BadCredentialsException extends AuthenticationException
{
    /**
     * BadCredentialsException constructor.
     */
    public function __construct()
    {
        parent::__construct(ApiCode::getMessage(ApiCode::BAD_CREDENTIALS), ApiCode::BAD_CREDENTIALS);
    }
}
