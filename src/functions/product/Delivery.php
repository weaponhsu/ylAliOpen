<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;
use ylAlibaba\core\ylAlibabaException;

class Delivery extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";

    /**
     * 获取运单号
     * @return mixed
     * @throws ylAlibabaException
     */
    public function getLogisticsInfos()
    {
        $this->url_info = 'com.alibaba.logistics:alibaba.trade.getLogisticsInfos.buyerView-1';

        $resp = $this->post();

        if (isset($resp['error_message']))
            throw new ylAlibabaException($resp['error_message'], 400);

        if (isset($resp['result']) && ($resp['success'] === true || $resp['success'] == 'true'))
            return [$resp['result'][0]['logisticsBillNo'], $resp['result'][0]['logisticsCompanyName']];
        else
            throw new ylAlibabaException('接口异常', 400);
    }

    /**
     * 获取交易订单的物流跟踪信息(买家视角)
     * @return mixed
     * @throws ylAlibabaException
     */
    public function getLogisticsTraceInfo()
    {
        $this->url_info = 'com.alibaba.logistics:alibaba.trade.getLogisticsTraceInfo.buyerView-1';

        $resp = $this->post();


        if (isset($resp['errorMessage']))
            throw new ylAlibabaException($resp['errorMessage'], 400);

        if (isset($resp['result']) && ($resp['success'] === true || $resp['success'] == 'true'))
            return $resp;
        else
            throw new ylAlibabaException('接口异常', 400);
    }

}
