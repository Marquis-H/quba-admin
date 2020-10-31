<?php
/**
 * ApiCode.php
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

namespace WeappApiBundle\Constants;

/**
 * Class ApiCode
 * @package WeappApiBundle\Constants
 */
class ApiCode
{
    const SUCCESS_MESSAGE = 'SUCCESS';
    const FAILURE_MESSAGE = 'FAILURE';

    const BAD_CREDENTIALS = 1000;
    const API_KEY_INVALID = 1001;

    /**
     * 服務錯誤
     */
    const SERVER_ERROR = 500500;
    /**
     * 缺少必要的請求參數
     */
    const MISSING_REQUIRED_PARAMETER = 500400;
    /**
     * 邏輯數據錯誤
     */
    const DATA_ERROR = 400500;
    const DATA_LOCK = 403403;
    const DATA_NOT_FOUND = 400400;
    const DATA_INVALID = 400300;
    const PROFILE_NOT_FOUND = 400401;

    /**
     * @param int $code
     * @return string
     */
    static public function getMessage(int $code): string
    {
        switch ($code) {
            case self::BAD_CREDENTIALS:
                return 'Invalid authentication';
            case self::API_KEY_INVALID:
                return 'Invalid ApiKey';
            default:
                return self::FAILURE_MESSAGE;
        }
    }
}
