<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;
use ylAlibaba\core\ylAlibabaException;

class Product extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";
    /**
     * 订单列表
     * @return $this
     */
    public function productFollow() {
        $this->url_info = "com.alibaba.product:alibaba.product.follow-1";

        return $this;
    }

    /**
     * 获取我的选品库
     * @return $this
     */
    public function productListCybUserGroup() {
        $this->url_info = "com.alibaba.p4p:alibaba.cps.op.listCybUserGroup-1";

        return $this;
    }

    /**
     * 获取指定选品库下的商品
     * @return $this
     */
    public function productListCybUserGroupFeed() {
        $this->url_info = "com.alibaba.p4p:alibaba.cps.op.listCybUserGroupFeed-1";

        return $this;
    }

    /**
     * 获取商品详情接口
     * @return $this
     */
    public function productCpsMediaProductInfo() {
        $this->url_info = "com.alibaba.product:alibaba.cpsMedia.productInfo-1";

        return $this;
    }

    /**
     * 获取营销活动价格等活动信息
     * @return $this
     */
    public function productQueryOfferDetailActivity() {
        $this->url_info = "com.alibaba.p4p:alibaba.cps.queryOfferDetailActivity-1";

        return $this;
    }

    public function getResp() {

        $resp = $this->post();

        if (! isset($resp['success']) || $resp['success'] != 'true') {
            $msg = $this->url_info . self::ERR_MSG;
            foreach ($resp as $idx => $value) {
                if (strpos($msg, '#' . $idx . '#') !== false)
                    $msg = str_replace('#' . $idx . '#', $value, $msg);
            }
            throw new ylAlibabaException($msg);
        }

        return $resp;

    }
}
