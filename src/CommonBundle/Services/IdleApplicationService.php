<?php


namespace CommonBundle\Services;


use Util\Str;

class IdleApplicationService extends AbstractService
{
    /**
     * 生成訂單號
     * 3位隨機＋4位機器ID+9位訂單ID
     * @param $diningId
     * @return string
     */
    public function buildOrderReceiptNumber($diningId)
    {
        try {
            $conn = $this->container->get('doctrine.orm.default_entity_manager')->getConnection();
            $max = $conn->fetchColumn("SELECT `id` FROM `weapp_idle_profile` ORDER BY `id` DESC LIMIT 1");
            $max += 1;
            $rand_n_m = mt_rand(100, 999) . str_pad($diningId, 4, '0', STR_PAD_LEFT);
            return $rand_n_m . str_pad($max, 9, '0', STR_PAD_LEFT);
        } catch (\Exception $e) {
            return Str::generateUniqidString();
        }
    }
}
