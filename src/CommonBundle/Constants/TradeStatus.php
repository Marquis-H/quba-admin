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
}
