<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;
use ylAlibaba\core\ylAlibabaException;

/**
 * Class Product
 * @package ylAlibaba\functions\product
 */
class Product extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";

    /**
     * 根据product_id关注产品
     * @return mixed
     * @throws ylAlibabaException
     */
    public function productFollow() {
        $this->url_info = "com.alibaba.product:alibaba.product.follow-1";

        $resp = $this->post();

        if (isset($resp['code']) && $resp['code'] == 0 && isset($resp['message']) && $resp['message'] == 'success')
            return $resp;

        throw new ylAlibabaException("产品关注失败");
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
     * @return mixed
     * @throws ylAlibabaException
     */
    public function productCpsMediaProductInfo() {
        $this->url_info = "com.alibaba.product:alibaba.cpsMedia.productInfo-1";

        $resp = $this->post();

        if (! isset($resp['success']) || $resp['success'] != true) {
            $msg = $this->url_info . self::ERR_MSG;
            foreach ($resp as $idx => $value) {
                if (strpos($msg, '#' . $idx . '#') !== false)
                    $msg = str_replace('#' . $idx . '#', $value, $msg);
            }
            throw new ylAlibabaException($msg);
        }

        return $resp;
    }

    /**
     * 获取营销活动价格等活动信息
     * @return mixed
     * @throws ylAlibabaException
     */
    public function productQueryOfferDetailActivity() {
        $this->url_info = "com.alibaba.p4p:alibaba.cps.queryOfferDetailActivity-1";

        $resp = $this->post();

        if (empty($resp))
            return $resp;
        if (! isset($resp['success']) || $resp['success'] !== true) {

        }

        return $resp['result'];
    }

    public function productUnFollow() {
        $this->url_info = "com.alibaba.product:alibaba.product.unfollow.crossborder-1";

        return $this;
    }

    public function getResp() {

        $resp = $this->post();

        if (! isset($resp['result']['success']) || $resp['result']['success'] !== true) {
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
