<?php
/**
 * Created by PhpStorm.
 * User: dxw
 * Date: 2020/1/20
 * Time: 5:48 PM
 */

namespace CommonBundle\Constants;


abstract class ApiCode
{
    /**
     * 服務錯誤
     */
    const SERVER_ERROR = 500500;
    /**
     * 缺少必要的請求參數
     */
    const MISSING_REQUIRED_PARAMETER = 400200;
    /**
     * 邏輯數據錯誤
     */
    const DATA_ERROR = 400500;
    const DATA_LOCK = 403403;
    const DATA_NOT_FOUND = 400400;
    const DATA_INVALID = 400300;
    const DATA_EXIST = 400200;
    const FAILED_DECRYPT_MESSAGE = -1001;
    const PROFILE_NOT_FOUND = 400401;
    const VOTE_EXPIRED = 400402;
    const VOTE_INVALID = 400403;
}
