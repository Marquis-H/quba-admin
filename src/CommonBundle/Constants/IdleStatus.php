<?php


namespace CommonBundle\Constants;


/**
 * Class IdleStatus
 * @package CommonBundle\Constants
 */
abstract class IdleStatus
{
    /**
     * 上架
     */
    const ONLINE = 'Online';
    /**
     * 进行中
     */
    const Doing = 'Doing';
    /**
     * 下架
     */
    const OFFLINE = 'Offline';
}
