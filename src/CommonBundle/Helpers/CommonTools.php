<?php
/**
 * Created by PhpStorm.
 * User: dxw
 * Date: 2020/1/20
 * Time: 5:47 PM
 */

namespace CommonBundle\Helpers;

use CommonBundle\Constants\ApiCode;
use CommonBundle\Exception\ApiException;
use DateTime;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Class CommonTools
 * @package CommonBundle\Helpers
 */
class CommonTools
{
    /**
     * @param bool $long
     * @return string
     */
    public static function getRealIp($long = false)
    {
        if (isset($_SERVER["HTTP_CLIENT_IP"])) {
            $ips = $_SERVER["HTTP_CLIENT_IP"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
            $ips = $_SERVER["HTTP_X_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_X_FORWARDED"])) {
            $ips = $_SERVER["HTTP_X_FORWARDED"];
        } elseif (isset($_SERVER["HTTP_FORWARDED_FOR"])) {
            $ips = $_SERVER["HTTP_FORWARDED_FOR"];
        } elseif (isset($_SERVER["HTTP_FORWARDED"])) {
            $ips = $_SERVER["HTTP_FORWARDED"];
        } else {
            $ips = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
        }
        if ($long) {
            return $ips;
        }
        $ips = explode(',', $ips);
        return isset($ips[0]) ? $ips[0] : '';
    }

    /**
     * @param $d1 DateTime
     * @param $d2 DateTime
     * @return string
     */
    public static function dateTimeSub($d1,$d2){
        $time = $d1->getTimestamp() - $d2->getTimestamp();
        $yourday = (int)($time/(3600*24));
        $yourhour = (int)(($time%(3600*24))/(3600));
        $yourmin = (int)($time%(3600)/60);
        return $yourday.'天'.$yourhour.'小时'.$yourmin.'分';
    }

    /**
     * 接口中，判断必须参数是否有传递
     * @param $data
     * @param $keys
     * @throws ApiException
     */
    public static function checkParams($data, $keys)
    {
        if (!is_array($data))
            throw new ApiException(sprintf("傳入數據非法 %s", $data), ApiCode::MISSING_REQUIRED_PARAMETER);
        $access = PropertyAccess::createPropertyAccessor();
        foreach ($keys as $v) {
            $val = $access->getValue($data, "[$v]");
            if (is_array($val) && empty($val)) {
                throw new ApiException(sprintf("'參數 %s 不能为空'", $val), ApiCode::MISSING_REQUIRED_PARAMETER);
            }
            if (($val === '') || ($val === null)) {
                throw new ApiException(sprintf("'缺少 %s 參數'", implode(',', $keys)), ApiCode::MISSING_REQUIRED_PARAMETER);
            }
        }
    }

    /**
     * @param $str
     * @return string|string[]
     */
    public static function trimall($str)
    {
        $oldChar = array("\t", "\n", "\r");
        $newChar = array("", "", "");

        $new = str_replace($oldChar, $newChar, $str);

        return preg_replace("/>([ ]+)</si", "><", $new);
    }

    /**
     * 無限極分類
     * @param $list
     * @param int $pid
     * @return array
     */
    public static function getTree($list, $pid = 0)
    {
        $tree = [];
        if (!empty($list)) {
            $newList = [];
            foreach ($list as $k => $v) {
                $newList[$v['id']] = $v;
                $newList[$v['id']]['child'] = null;
            }
            foreach ($newList as $value) {
                if ($pid == $value['pid']) {
                    $tree[] = &$newList[$value['id']];
                } elseif (isset($newList[$value['pid']])) {
                    $newList[$value['pid']]['child'][] = &$newList[$value['id']];
                }
            }
        }
        return $tree;
    }

    /**
     * @param $list
     * @param int $pid
     * @return array
     */
    public static function orderTree($list, $pid = 0)
    {
        static $tree = [];
        if (!empty($list)) {
            foreach ($list as $k => $v) {
                if ($v['pid'] == $pid) {
                    $tree[] = $v;
                    self::orderTree($list, $v['id']);
                }
            }
        }
        return $tree;
    }

    /**
     * @param int $length
     * @return bool|string
     */
    public static function genCaptcha($length = 6)
    {
        $str = '0123456789';
        $i = 1;
        while ($i < $length) {
            $str .= $str;
            $i++;
        }
        $str = str_shuffle($str);
        return substr($str, 0, $length);
    }
}
