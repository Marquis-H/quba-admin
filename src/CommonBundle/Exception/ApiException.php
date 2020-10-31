<?php
/**
 * @author will <wizarot@gmail.com>
 * @link http://wizarot.me/
 *
 * Date: 2018/7/31
 * Time: 下午3:11
 */

namespace CommonBundle\Exception;

use CommonBundle\Constants\ApiCode;
use Throwable;

// 自定义一个api专有的exception用于区分服务器内部错误和执行api过程中的异常
class ApiException extends \Exception
{
    /**
     * ApiException constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = ApiCode::DATA_NOT_FOUND, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
