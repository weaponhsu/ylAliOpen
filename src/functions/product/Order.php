<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;
use ylAlibaba\core\ylAlibabaException;

/**
 * Class Order
 * @package ylAlibaba\functions\product
 */
class Order extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";

    /**
     * 根据地址解析地区码
     * @return mixed
     * @throws ylAlibabaException
     */
    public function tradeAddressCodeParse() {
        $this->url_info = "com.alibaba.trade:alibaba.trade.addresscode.parse-1";

        $resp = $this->post();

        // 接口调用失败，通常是没有权限调用
        if (isset($resp['error_code']) && isset($resp['error_message'])) {
            $msg = $this->url_info . self::ERR_MSG;
            foreach ($resp as $idx => $value) {
                if (strpos($msg, '#' . $idx . '#') !== false)
                    $msg = str_replace('#' . $idx . '#', $value, $msg);
            }

            throw new ylAlibabaException($msg);
        }
        // 需要根据接口实际情况进行调整
        else if (isset($resp['errorCode']) && $resp['errorCode'] != 0) {
            $msg = '根据地址解析地区码接口报错: ' . $resp['errorMessage'];
            throw new ylAlibabaException($msg);
        }


        return $resp['result'];
    }

    /**
     * 溢价模式创建订单前预览数据接口
     * @return $this
     */
    public function createOrderPreview4CybMedia() {
        $this->url_info = "com.alibaba.trade:alibaba.createOrder.preview4CybMedia-1";

        return $this;
    }

    /**
     * 溢价模式订单创建接口
     * @return $this
     */
    public function tradeCreateOrder4CybMedia() {
        $this->url_info = "com.alibaba.trade:alibaba.trade.createOrder4CybMedia-1";

        return $this;
    }

    /**
     * 支付宝协议支付
     * @return $this
     */
    public function tradePayProtocalPay() {
        $this->url_info = "com.alibaba.trade:alibaba.trade.pay.protocolPay-1";
        return $this;
    }

    /**
     * 解析部分接口的返回结果
     * @return mixed
     * @throws ylAlibabaException
     */
    public function getResp() {
        $resp = $this->post();

        if (! isset($resp['success']) || $resp['success'] != true) {

            $msg = $this->url_info . self::ERR_MSG;
            foreach ($resp as $idx => $value) {
                if (strpos($msg, '#' . $idx . '#') !== false)
                    $msg = str_replace('#' . $idx . '#', $value, $msg);
            }

            if (strpos($msg, '#error_code#') !== false)
                $msg = str_replace('#error_code#', $resp['errorCode'], $msg);
            if (strpos($msg, '#error_message#') !== false)
                $msg = str_replace('#error_message#', $resp['errorMsg'], $msg);
            if (strpos($msg, '#exception#') !== false)
                $msg = str_replace('#exception#', '接口调用失败', $msg);

            throw new ylAlibabaException($msg);
        }

        return $resp;
    }

}
