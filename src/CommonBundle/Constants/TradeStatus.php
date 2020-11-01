<?php


namespace CommonBundle\Constants;


/**
 * Class TradeStatus
 * @package CommonBundle\Constants
 */
abstract class TradeStatus
{
    /**
     * 进行中
     */
    const Doing = 'Doing';

    /**
     * 交易完成
     */
    const Done = 'Done';

    /**
     * 交易取消
     */
    const Cancel = 'Cancel';

    /**
     * @param $status
     * @return string
     */
    static public function getTitle($status)
    {
        switch ($status) {
            case 'Doing':
                return '进行中';
            case 'Done':
                return '交易完成';
            case 'Cancel':
                return '交易取消';
            default:
                return '-';
        }
    }
}
