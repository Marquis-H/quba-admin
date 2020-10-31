<?php
/**
 * ApiException.php
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
use Throwable;
use Util\Json;

/**
 * Class ApiException
 * @package WeappApiBundle\Exceptions
 */
class WeappApiException extends \Exception
{
    /**
     * ApiException constructor.
     * @param string|array $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message, $code = ApiCode::DATA_NOT_FOUND, Throwable $previous = null)
    {
        if (is_array($message)) {
            $message = Json::encode($message);
        }
        parent::__construct($message, $code, $previous);
    }
}
