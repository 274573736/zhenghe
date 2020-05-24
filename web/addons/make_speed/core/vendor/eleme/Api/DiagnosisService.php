<?php

namespace ElemeOpenApi\Api;

/**
 * 经营体检
 */
class DiagnosisService extends RpcService
{

    /** 根据商户_i_d查询商户经营体检信息
     * @param $shop_id 店铺ID
     * @param $date 体检日期(最多查到7天内的体检数据)
     * @return mixed
     */
    public function get_shop_diagnosis($shop_id, $date)
    {
        return $this->client->call("eleme.diagnosis.getShopDiagnosis", array("shopId" => $shop_id, "date" => $date));
    }

    /** 根据多个商户_i_d批量查询商户经营体检信息
     * @param $shop_ids 店铺ID集合
     * @param $date 体检日期(最多查到7天内的体检数据)
     * @return mixed
     */
    public function get_shop_diagnosis_list($shop_ids, $date)
    {
        return $this->client->call("eleme.diagnosis.getShopDiagnosisList", array("shopIds" => $shop_ids, "date" => $date));
    }

}