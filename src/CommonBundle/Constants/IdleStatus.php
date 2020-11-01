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

    /**
     * @param $status
     * @return string
     */
    static public function getTitle($status)
    {
        switch ($status) {
            case 'Online':
                return '正在出售';
            case 'Doing':
                return '进行中';
            case 'Offline':
                return '下架';
            default:
                return '-';
        }
    }
}
