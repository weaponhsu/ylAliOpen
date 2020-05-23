<?php
if (! file_exists(realpath(dirname(__FILE__)) . '/vendor/autoload.php'))
    exit('not exit');

require_once realpath(dirname(__FILE__)) . '/vendor/autoload.php';

use Yaf\Registry;
use ylAlibaba\AliOpen;
use ylAlibaba\core\ylAlibabaException;

$order_id = '1016932098506070029';
//$order_id = 'abcv';

list($delivery_no, $company_name) = Alibaba::getDeliveryNo($order_id);
var_dump($delivery_no, $company_name);

var_dump(Alibaba::getLogisticsTraceInfo($order_id, $delivery_no));
exit();

// 退款、退货
// 1688订单编号 order表中的trade_order_sn
/*$alibaba_order_id = '1688-orderId-' . time();
// 退款的订单状态
//$stats = 1;
// 退货的订单状态
$stats = 2;

$refund_reasons_list = Alibaba::getTradeRefundReasonList($alibaba_order_id, $stats);

// 订单金额 单位分
$amount = 720;
// 运费 单位分
$carriage = 100;
// 退款原因编号 客户端、前端提交
// 测试条件下为随机数
$key = array_rand($refund_reasons_list, 1);
$reason_id = $refund_reasons_list[$key]['id'];
// 退货、退款原因客户端、前端提交
$description = "退货、退款原因";
// 退货凭证 客户度、前端提交
$vouchers = ['http://www.ylmall.com/upload/sku/5e8170c255760.jpg', 'http://www.ylmall.com/upload/sku/5e816796b0b91.png'];

// 上传凭证
$vouchers_arr = Alibaba::tradeUploadRefundVoucher($vouchers);

$res = Alibaba::getTradeCreateRefund($alibaba_order_id, $amount, $carriage, $reason_id, $description, $stats, $vouchers_arr);
// 退款、退货订单号，需要保存到数据库中
$refund_order_id = $res['result']['refundId'];

// 退货的情况
if ($stats === 2) {
    // 以下两个接口具体用哪个暂时也不清楚，等申请接口的时候再找小二问清楚
    // 获取所有的物流公司名称
    //$logistic_company_list = Alibaba::getLogisticsOpQueryLogisticCompanyList();
    // 查询自己联系物流的物流公司列表
    $logistic_company_list = Alibaba::getLogisticsOpQueryLogisticCompanyListOffline();

    // 物流公司编码
    // 测试条件下为随机数
    $key = array_rand($logistic_company_list, 1);
    $logistics_company_no = $logistic_company_list[$key]['id'];
    // 运单号，客户端、前端提交
    $freight_bill = '123312';
    // 发货说明，内容在2-200个字之间，客户端、前端提交
    $description = '123321';
    // 凭证图片URLs，uploadRefundVoucher接口返回结果
    $vouchers = ['http://www.ylmall.com/upload/product_main_image/5e817f251cdb7.jpg', 'http://www.ylmall.com/upload/product_main_image/5e8208f86ca55.png'];

    // 上传凭证
    $vouchers_arr = Alibaba::tradeUploadRefundVoucher($vouchers);

    $res = Alibaba::tradeRefundReturnGoods($refund_order_id, $logistics_company_no, $freight_bill, $description, $vouchers_arr);
    var_dump($res);
}

exit();*/

// 获取收货地址+溢价模式预览订单+溢价模式下单+协议支付
$address_id = 4;
$product_id = '584051070147';
$spec_id = 'af478130f6c683c4c77bb511796617b8';
$num = 2;

// 获取收货地址信息
//$address_list = Alibaba::getTradeAddressCodeParse($address_id);
//var_dump($address_list);


// 以下两个接口具体用哪个暂时也不清楚，等申请接口的时候再找小二问清楚
// 获取所有的物流公司名称
$logistic_company_list = Alibaba::getLogisticsOpQueryLogisticCompanyList();
// 查询自己联系物流的物流公司列表
//$logistic_company_list = Alibaba::getLogisticsOpQueryLogisticCompanyListOffline();
//var_dump($logistic_company_list);

$arr = [];
foreach ($logistic_company_list as $val) {
    if ($val['companyName'] == '韵达') {
        array_push($arr, $val);
    } else if ($val['companyName'] == '顺丰') {
        array_push($arr, $val);
    } else if ($val['companyName'] == '申通') {
        array_push($arr, $val);
    } else if ($val['companyName'] == '圆通') {
        array_push($arr, $val);
    } else if ($val['companyName'] == '邮政') {
        array_push($arr, $val);
    }
}

echo json_encode($arr);
exit();

/*
// 获取收货地址+溢价模式预览订单+溢价模式下单+协议支付
$address_id = 4;
$product_id = '584051070147';
$spec_id = 'af478130f6c683c4c77bb511796617b8';
$num = 2;

// 溢价模式预览订单
Alibaba::getCreateOrderPreview4CybMedia($product_id, $num, $address_list, $spec_id);

$order_info = [
    'sn' => '系统订单编号',
    'phone' => '下单用户手机号',
    'product_id' => $product_id,
    'spec_id' => $spec_id,
    'amount' => 7.2,
    'num' => '2'
];
// 溢价模式创建订单
// 该接口返回的postFee为运费，运费若不为0时，需要于退货退款时需要的applyCarriage的值保持一致
$alibaba_order_id = Alibaba::getTradeCreateCybMedia($product_id, $num, $spec_id, $address_list, $order_info);

$r = Alibaba::getTradePayProtocolPay($alibaba_order_id);
var_dump($r);
exit('done');*/

/*$product_id = '587900870454';
list($product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr) =
    Alibaba::getProductCpsMediaProductInfo($product_id);
var_dump($product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr);
$product_id = '556373255591';
list($product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr) =
    Alibaba::getProductCpsMediaProductInfo($product_id);
var_dump($product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr);
exit();*/

// 关注产品
$product_id = '122398006';
$res = Alibaba::getProductFollow($product_id);
var_dump($res);
$res = Alibaba::unFollowProduct($product_id);
var_dump($res);
exit();

// 查询获取选品库已选商品列表
$feed_id = 1;
$page_size = 10;
$product_arr = [];
try {
    $product_arr = $match_product_arr = [];
    $user_group = Alibaba::getProductListCybUserGroup(1);

    foreach ($user_group['result']['result'] as $group_info) {
        $total_page = ceil($group_info['feedCount'] / $page_size);
        for ($page = 1; $page <= $total_page; $page++) {
            $product_list = Alibaba::getProductListCybUserGroupFeed($group_info['id'], 1);
            if (!empty($product_list) && empty($product_arr) && empty($match_product_arr)) {
                $product_arr = $product_list;
                $match_product_arr = array_column($product_list, 'product_id');
            }
            else if (!empty($product_list) && !empty($product_arr)) {
                $product_id_arr = array_column($product_list, 'product_id');
                $diff_product_id_arr = array_diff($product_id_arr, $match_product_arr);
                if (!empty($diff_product_id_arr)) {
                    $product_arr = array_merge($product_arr, $product_list);
                    $match_product_arr = array_merge($match_product_arr, $diff_product_id_arr);
                }
            }
        }
    }

    if (! empty($product_arr)) {
        $sku_array = $product_sku_array = $sale_info_array = $shipping_array = $freight_array = $attribute_array = $promotion_information_array =
            $product_activity_array = $activity_array = $product_array = [];
        foreach ($product_arr as $idx => $product_info) {
            $promotion_information = [];
            // 查询商品详情
//            list($sku_arr, $product_sku_arr, $sale_info_arr, $shipping_arr, $freight_arr, $attribute_arr) =
            list($product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr) =
                Alibaba::getProductCpsMediaProductInfo($product_info['product_id']);
            // 查询营销活动
            list($activity_info, $product_activity_info) = Alibaba::getProductQueryOfferDetailActivity($product_info['product_id']);
            if (!empty($product_activity_info)) {
                if (empty($product_activity_array))
                    array_push($product_activity_array, $product_activity_info);
                else
                    $product_activity_array = array_merge($product_activity_array, $product_activity_info);
            }

            if (!empty($activity_info)) {
                if (empty($activity_array))
                    array_push($activity_array, $activity_info);
                else
                    $activity_array = array_merge($activity_array, $activity_info);
            }
//            var_dump($sku_arr, $product_sku_arr, $sale_info_arr, $shipping_arr, $freight_arr, $attribute_arr, $promotion_information);

            if (!empty($sku_arr))
                $sku_array = array_merge($sku_array, $sku_arr);

            if (!empty($product_sku_arr))
                $product_sku_array = array_merge($product_sku_array, $product_sku_arr);

            if (!empty($product_arr))
                $product_array = array_merge($product_array, $product_arr);

            if (!empty($shipping_arr))
                $sale_info_array = array_merge($shipping_array, $shipping_arr);

            if (!empty($freight_arr))
                $freight_array = array_merge($freight_array, $freight_arr);

        }

    }

} catch (ylAlibabaException $e) {
    echo $e->getMessage();
}
var_dump($product_array, $product_sku_array, $sku_array, $shipping_array, $freight_array);
exit('done');

/*
// 查询商品分类
// 0 -> 97 -> 201303115 -> 82105
$category_id = 201303115;
try {
    $res = Alibaba::getSubCategoryById($category_id);
} catch (ylAlibabaException $e) {
    echo $e->getMessage();
}*/


class Alibaba {

    const APP_SECRET = "9KxUA0WTFJA";
    const APP_KEY = "4911751";
    const ACCESS_TOKEN = "478884a3-0e07-4585-affa-ac1384ef8a40";

    static public function getLogisticsTraceInfo($order_id, $delivery_id) {

        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行

        $ali->params = [
            'orderId' => $order_id,
            'logisticsId' => $delivery_id,
            'webSite' => '1688'
        ];

        try {
            $resp = $ali->delivery->getLogisticsTraceInfo();

            return $resp;
        } catch (ylAlibabaException $e) {
            throw $e;
        }
    }

    /**
     * 通过1688订单号，获取运单号
     * @param string $order_id
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getDeliveryNo($order_id = '') {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行

        $ali->params = [
            'orderId' => $order_id,
            'fields' => 'company,name,sendgood,receiver',
            'webSite' => '1688'
        ];

        try {
            $resp = $ali->delivery->getLogisticsInfos();

            return $resp;
        } catch (ylAlibabaException $e) {
            throw $e;
        }
    }

    /**
     * 买家提交退款货信息 在1688卖家同意退货后调用
     * @param $refund_order_id
     * @param $logistics_company_no
     * @param $freight_bill
     * @param string $description
     * @param array $vouchers
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function tradeRefundReturnGoods($refund_order_id, $logistics_company_no, $freight_bill, $description = '', $vouchers = []) {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradeRefundReturnGoods";

        $ali->params = [
            'refundId' => $refund_order_id,
            'logisticsCompanyNo' => $logistics_company_no,
            'freightBill' => $freight_bill,
            'description' => $description,
            'vouchers' => json_encode($vouchers)
        ];

        try {
            $resp = $ali->order->tradeRefundReturnGoods();

            return $resp['result'];
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 获取所有的物流公司
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getLogisticsOpQueryLogisticCompanyListOffline() {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->order->setMode('development');
//        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/logisticsOpQueryLogisticCompanyListOffline";

        try {

            $resp = $ali->order->logisticsOpQueryLogisticCompanyList()->getResp();
            return $resp['result'];
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 获取所有的物流公司
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getLogisticsOpQueryLogisticCompanyList() {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->order->setMode('development');
//        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/logisticsOpQueryLogisticCompanyList";

        try {

            $resp = $ali->order->logisticsOpQueryLogisticCompanyList()->getResp();
            return $resp['result'];
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 上传退货退款凭证
     * @param array $vouchers
     * @return array
     */
    static public function tradeUploadRefundVoucher($vouchers = []) {
        $return_arr = [];
        try {
            $ali = new AliOpen();
            $ali->setAppKey(static::APP_KEY);
            $ali->setAppSecret(static::APP_SECRET);

            // 测试时使用本地接口 正式接口调用时 注释掉下面两行
            $ali->order->setMode('development');
            $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradeUploadRefundVoucher";

            foreach ($vouchers as $idx => $voucher) {
                $file_path = str_replace('http://www.ylmall.com/', '/Users/huangxu/PhpstormProjects/ylmall/public/', $voucher);
                if (file_exists($file_path)) {

                    $ali->params = [
                        'imageData' => new CURLFile($file_path)
                    ];

                    $resp = $ali->order->uploadRefundVoucher();

                    array_push($return_arr, $resp['imageDomain'] . $resp['imageRelativeUrl']);
                }
            }

            return $return_arr;
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
        } finally {
            return $return_arr;
        }

    }

    /**
     * 发起退款、退货申请
     * @param $alibaba_order_id
     * @param $amount
     * @param $carriage
     * @param $reason_id
     * @param $description
     * @param $stats
     * @param array $vouchers
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getTradeCreateRefund($alibaba_order_id, $amount, $carriage, $reason_id, $description, $stats, $vouchers = []) {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 根据"卖家未发货时允许退款；买家收到货后确认收货前允许退货"需求
        // 顾，允许退款的订单状态为1(未发货)对应1688的状态为"refundWaitSellerSend(售中等待买家发货)"
        // 允许退货的订单状态为2(已发货)对应1688的状态为"aftersaleBuyerReceived(售中等待买家收货)"
        switch ($stats) {
            // 售后已收到货 => aftersaleBuyerReceived(售中等待买家收货)
            case 2:
                $alibaba_stats = 'refundWaitBuyerReceive';
                $request = 'refund';
                break;
            // 待发货 => refundWaitSellerSend(售中等待买家发货:)
            default;
                $alibaba_stats = 'refundWaitSellerSend';
                $request = 'returnRefund';
                break;
        }
        $ali->params = [
            'orderId' => $alibaba_order_id,
            'orderEntryIds' => $alibaba_order_id,
            'disputeRequest' => $request,
            'applyPayment' => $amount,
            'applyCarriage' => $carriage,
            'applyReasonId' => $reason_id,
            'description' => $description,
            'goodsStatus' => $alibaba_stats,
            'vouchers' => json_encode($vouchers)
        ];
        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradeCreateRefund";

        try {
            return $ali->order->tradeCreateRefund();
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }

    }

    /**
     * 获取1688退款理由
     * @param $alibaba_order_id
     * @param $stats
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getTradeRefundReasonList($alibaba_order_id, $stats) {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 根据"卖家未发货时允许退款；买家收到货后确认收货前允许退货"需求
        // 顾，允许退款的订单状态为1(未发货)对应1688的状态为"refundWaitSellerSend(售中等待买家发货)"
        // 允许退货的订单状态为2(已发货)对应1688的状态为"aftersaleBuyerReceived(售中等待买家收货)"
        switch ($stats) {
            // 售后已收到货 => aftersaleBuyerReceived(售中等待买家收货)
            case 2:
                $alibaba_stats = 'refundWaitBuyerReceive';
                break;
            // 待发货 => refundWaitSellerSend(售中等待买家发货:)
            default;
                $alibaba_stats = 'refundWaitSellerSend';
                break;
        }
        $ali->params = [
            'orderId' => $alibaba_order_id,
            'orderEntryIds' => $alibaba_order_id,
            'goodsStatus' => $alibaba_stats
        ];
        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradeRefundReasonList";

        try {
            $resp = $ali->order->tradeRefundReasonList()->getResp();
            return $resp['result']['reasons'];
        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 根据地址解析地区码
     * @param $address_id
     * @return array
     * @throws ylAlibabaException
     */
    static public function getTradeAddressCodeParse($address_id) {
        // 查询数据库 address_id是否存在,并将地址生成"xxx省xxx市xxx区xxx街道xxx号"的形式
//        $address = '浙江省杭州市滨江区网商路699号';
        $address = '福建省厦门市湖里区国际石材中心A栋611';

        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        $ali->params = [
            'addressInfo' => $address
        ];
        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->order->setMode('development');
//        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/orderTradeAddressCodeParse";

        try {
            $address_info = $ali->order->tradeAddressCodeParse();
            // 日志记录地址解析地区码接口返回结果
            // some code...

            $post_code = $address_info['postCode'];
            $district_code = $address_info['addressCode'];

            return [
                'addressId' => $address_id,
                'mobile' => '',
                'phone' => '',
                'postCode' => $post_code,
                'cityText' => '',
                'provinceText' => '',
                'areaText' => '',
                'townText' => '',
                'address' => '',
                'districtCode' => $district_code
            ];

        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 溢价模式创建订单前预览数据接口
     * @param $product_id
     * @param $num
     * @param $address_list
     * @param string $spec_id
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getCreateOrderPreview4CybMedia($product_id, $num, $address_list, $spec_id = '') {
        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        $product_list = [
            'offerId' => $product_id,
            'quantity' => $num,
        ];
        if (!empty($spec_id))
            $product_list['specId'] = $spec_id;

        $ali->params = [
            'addressParam' => json_encode($address_list),
            'cargoParamList' => json_encode($product_list)
        ];

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/orderCreateOrderPreview4CybMedia";

        try {
            $resp = $ali->order->createOrderPreview4CybMedia()->getResp();
            // 日志记录溢价模式预览订单接口返回结果
            // some code...

        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }

    }

    /**
     * 创建溢价订单
     * @param $product_id
     * @param $num
     * @param $spec_id
     * @param $address_list
     * @param $order_list
     * @return mixed
     * @throws ylAlibabaException
     */
    static public function getTradeCreateCybMedia($product_id, $num, $spec_id, $address_list, $order_list) {
        if (empty($address_list) || ! is_array($address_list))
            throw new ylAlibabaException("创建溢价订单信息时收货地址必须为数据", 400);
        if (empty($order_list) || ! is_array($order_list))
            throw new ylAlibabaException("创建溢价订单信息时豆子有拼的订单信息必须为数据", 400);

        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        $product_list = [
            'offerId' => $product_id,
            'quantity' => $num,
        ];
        if (!empty($spec_id))
            $product_list['specId'] = $spec_id;

        $ali->params = [
            'addressParam' => json_encode($address_list),
            'cargoParamList' => json_encode($product_list),
            'message' => '此处是给卖家的留言，一般情况下需要提醒卖家不得透露自己的相关信息，具体内容参考文档',
            'outerOrderInfo' => json_encode($order_list),
        ];

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradeCreateOrder4CybMedia";

        try {
            $resp = $ali->order->tradeCreateOrder4CybMedia()->getResp();
            // 日志记录溢价模式预览订单接口返回结果
            // some code...

            // 返回1688订单编号，用以支付宝协议支付使用
            return $resp['result']['orderId'];

        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 1688使用支付宝协议支付对指定订单进行付款
     * @param $alibaba_order_id
     * @throws ylAlibabaException
     */
    static public function getTradePayProtocolPay($alibaba_order_id) {
        if (empty($alibaba_order_id))
            throw new ylAlibabaException("1688订单编号不能为空", 400);

        $ali = new AliOpen();
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        $ali->params = ['orderId' => $alibaba_order_id];

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
        $ali->order->setMode('development');
        $ali->order->res_url = "http://www.ylmall.com/common/alibabatest/tradePayProtocolPay";

        try {
            $ali->order->tradePayProtocalPay()->getResp();
            // 日志记录协议支付订单接口返回结果
            // 修改order表中对应订单的状态

        } catch (ylAlibabaException $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        } catch (Exception $e) {
            // 若接口抛错，记录下错误信息并抛出错误，发送通知消息给用户，告知下单失败请联系客服
            throw $e;
        }
    }

    /**
     * 获取我的选品库列表
     * @param $page
     * @return mixed
     */
    static public function getProductListCybUserGroup($page) {
        $ali = new AliOpen();
        $ali->params = ['pageNo' => $page, 'pageSize' => 10];
        if (!empty($feed_id))
            array_push($ali->params, ['feedId' => $feed_id]);
        if (!empty($title))
            array_push($ali->params, ['title' => $title]);
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = "http://www.ylmall.com/common/alibabatest/listCybUserGroup";

        return $ali->product->productListCybUserGroup()->getResp();
    }

    /**
     * 获取商品活动详情
     * @param $product_id
     * @return array
     */
    static public function getProductQueryOfferDetailActivity($product_id)
    {
        $ali         = new AliOpen();
        $ali->params = ['offerId' => $product_id, 'needCpsSuggestPrice' => true];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = Registry::get('config')['application']['host']."/common/alibabatest/queryOfferDetailActivity";

        $resp          = $ali->product->productQueryOfferDetailActivity();
        $promotion_arr = $promotion_product_arr = [];
        var_dump(array_keys($resp['result']));
        if (!empty($resp) && $resp['result']['offerId'] == $product_id) {
            list($datetime, $hour) = explode('+', $resp['result']['startTime']);
            $datetime   = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $start_time = date("Y-m-d H:i:s", $datetime);

            if (isset($resp['result']['hotTime']) && !empty($resp['result']['hotTime'])) {
                list($datetime, $hour) = explode('+', $resp['result']['hotTime']);
                $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
                $hot_time = date("Y-m-d H:i:s", $datetime);
            } else {
                $hot_time = '0000-00-00 00:00:00';
            }

            list($datetime, $hour) = explode('+', $resp['result']['endTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $end_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['freepostageStartTime']);
            $datetime                = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $free_postage_start_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['freepostageEndTime']);
            $datetime              = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $free_postage_end_time = date("Y-m-d H:i:s", $datetime);

            $promotion_product_arr['product_id']  = $resp['result']['offerId'];
            $promotion_product_arr['activity_id'] = $promotion_arr['activity_id'] = $resp['result']['activityId'];
            $promotion_arr['activity_name']       = $resp['result']['activityName'];
            // 预热时间,活动未开始,不可用活动价下单; 为null表示无预热时间
            $promotion_arr['hot_time'] = $hot_time;
            // 活动开始时间；大于now时，活动有效
            $promotion_arr['start_time'] = $start_time;
            // 活动结束时间；小于now时，活动有效
            $promotion_arr['end_time'] = $end_time;
            // 活动起批量
            $promotion_product_arr['begin_quantity'] = isset($resp['result']['beginQuantity']) ? $resp['result']['beginQuantity'] : 0;
            // 活动总库存，为null时使用offer原库存
            $promotion_product_arr['stock'] = isset($resp['result']['stock']) ? $resp['result']['stock'] : 0;
            // 商品本身限购数，非活动价可购买数；-1表示不限，0表示可购买数为0；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_product_arr['person_limit_count'] = $resp['result']['personLimitCount'];
            // 限购数，等于0且personLimitCount>0时，可以以原价下单，但不能以活动价下单；-1表示不限数量；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_product_arr['promotion_limit_count'] = $resp['result']['promotionLimitCount'];
            // 活动限购数；该场内活动商品限购数，-1表示不限购；0表示不可购买该场活动所有商品；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_product_arr['activity_limit_count'] = $resp['result']['activityLimitCount'];
            // 活动限时包邮开始时间；null 表示不限时
            $promotion_product_arr['free_postage_start_time'] = $free_postage_start_time;
            // 活动限时包邮结束时间；null 表示不限时
            $promotion_product_arr['free_postage_end_time'] = $free_postage_end_time;
            // 免包邮地区，与活动包邮配合使用
            $promotion_product_arr['exclude_area_list'] = isset($resp['result']['excludeAreaList']) ? json_encode($resp['result']['excludeAreaList']) : '';
            // 如果offer是范围报价，且价格优惠是折扣的情况，返回折扣计算后的价格范围;优先取该字段，该字段为空时，表示分sku报价，取promotionItemList
            $promotion_product_arr['range_price'] = isset($resp['result']['rangePrice']) ? json_encode($resp['result']['rangePrice']) : '';
            // 优惠结果，根据优惠方式（PromotionInfo），结合offer的原价信息，计算出优惠结果：每个sku或者每个区间价的促销价，折扣率
            $promotion_product_arr['promotion_item_list'] = isset($resp['result']['promotionItemList']) ? json_encode($resp['result']['promotionItemList']) : '';
            // sku维度的库存结果
            $promotion_product_arr['sku_stock_list']   = isset($resp['result']['skuStockList']) ? json_encode($resp['result']['skuStockList']) : '';
            $promotion_product_arr['intro_order_flow'] = $resp['result']['introOrderFlow'];
        }

        return [$promotion_arr, $promotion_product_arr];
    }
    /**
     * 获取指定选品库下的商品信息
     * @param $group_id
     * @param $page
     * @param int $page_size
     * @param string $feed_id
     * @param string $title
     * @return array
     */
    static public function getProductListCybUserGroupFeed($group_id, $page, $page_size = 10, $feed_id = '', $title = '') {
        $ali = new AliOpen();
        $ali->params = ['groupId' => $group_id,
            'pageNo' => $page, 'pageSize' => $page_size];
        if (!empty($feed_id))
            array_push($ali->params, ['feedId' => $feed_id]);
        if (!empty($title))
            array_push($ali->params, ['title' => $title]);
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = "http://www.ylmall.com/common/alibabatest/listCybUserGroupFeed";

        $resp = $ali->product->productListCybUserGroupFeed()->getResp();
        $return_arr = [];
        foreach ($resp['result']['resultList'] as $val) {
            if ($val['invalid'] === false) {
                array_push($return_arr, [
                    'product_id' => $val['feedId'],
                    'title' => $val['title'],
                    'price' => $val['price'],
                    'promotion_price' => isset($val['promotionPrice']) ? $val['promotionPrice'] : 0.00,
                    'img_url' => $val['imgUrl'],
                    'sales' => isset($val['saleCount']) ? $val['saleCount'] : 0,
                    'channel_price' => isset($val['channelPrice']) ? $val['channelPrice'] : 0.00
                ]);
            }
        }

        return $return_arr;
    }

    /**
     * 获取产品详情
     * @param $product_id
     * @return mixed
     */
    static public function getProductCpsMediaProductInfo($product_id) {
        $ali = new AliOpen();
        $ali->params = ['offerId' => $product_id, 'needCpsSuggestPrice' => true];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = "http://www.ylmall.com/common/alibabatest/productInfo";

        $product_information = $ali->product->productCpsMediaProductInfo();

        $product_arr = $sku_arr = $product_sku_arr = $shipping_arr = $freight_arr = $attribute_arr = $match_sku_id_arr = [];
        if ($product_information['productInfo']['productID'] == $product_id
            && in_array($product_information['productInfo']['status'], ['published', 'modified', 'new', 'approved'])
            /*&& $product_information['productInfo']['saleInfo']['supportOnlineTrade'] == 'true'*/
        ) {
            // 类目ID，标识商品所属类目
            $product_arr['category_id'] = $product_information['productInfo']['categoryID'];
            // 分组ID，确定商品所属分组。1688可传入多个分组ID，国际站同一个商品只能属于一个分组，因此默认只取第一个
            $product_arr['group_id'] = isset($product_information['productInfo']['groupID']) ? $product_information['productInfo']['groupID'][0] : 0;
            // 商品标题，最多128个字符
            $product_arr['title'] = $product_information['productInfo']['subject'];
            // 商品详情描述，可包含图片中心的图片URL
            $product_arr['description'] = $product_information['productInfo']['description'];
            // pictureAuth为图片是否私密字段
            // 若pictureAuth为false时，读取images
            // images为主图列表，使用相对路径，需要增加域名：https://cbu01.alicdn.com/
            if ($product_information['productInfo']['pictureAuth'] === false) {
                foreach ($product_information['productInfo']['image']['images'] as $idx => $url) {
                    $product_information['productInfo']['image']['images'][$idx] = /*'https://cbu01.alicdn.com/' .*/ $url;
                }
                $product_arr['images'] = json_encode( $product_information['productInfo']['image']['images']);
            } else
                $product_arr['images'] = '';
            // 质量星级(0-5)
            $product_arr['quality_level'] = $product_information['productInfo']['qualityLevel'];
            // 供应商loginId
            $product_arr['supplier_loginId'] = $product_information['productInfo']['supplierLoginId'];
            // 类目名
            $product_arr['category_name'] = $product_information['productInfo']['categoryName'];
            // 主图视频播放地址 绝对路径
            $product_arr['main_vedio'] = $product_information['productInfo']['mainVedio'];
            // 商品货号，产品属性中的货号
            $product_arr['product_cargo_number'] = isset($product_information['productInfo']['productCargoNumber']) ? $product_information['productInfo']['productCargoNumber'] : '';
            // 参考价格，返回价格区间，可能为空
            $product_arr['reference_price'] = $product_information['productInfo']['referencePrice'];
            // 商品状态。
            // published:上网状态;
            // member expired:会员撤销;
            // auto expired:自然过期;
            // expired:过期(包含手动过期与自动过期);
            // member deleted:会员删除;
            // modified:修改;
            // new:新发;
            // deleted:删除;
            // TBD:to be delete;
            // approved:审批通过;
            // auditing:审核中;
            // untread:审核不通过;
            $product_arr['alibaba_stats'] = $product_information['productInfo']['status'];

            // 商品销售信息
            if (isset($product_information['productInfo']['saleInfo']) && !empty($product_information['productInfo']['saleInfo'])
            ) {
                $product_arr['product_id'] = $product_information['productInfo']['productID'];
                // 是否支持网上交易。true：支持 false：不支持
                $product_arr['support_online_trade'] = $product_information['productInfo']['saleInfo']['supportOnlineTrade'] == 'true' ? 1 : 0;
                // 是否支持混批
                $product_arr['mix_whole_sale'] = $product_information['productInfo']['saleInfo']['mixWholeSale'] == 'true' ? 1 : 0;
                // 是否价格私密信息
                $product_arr['price_auth'] = $product_information['productInfo']['saleInfo']['priceAuth'] == 'true' ? 1 : 0;
                if ($product_arr['price_auth'] == 0) {
                    $product_arr['price_ranges'] = json_encode($product_information['productInfo']['saleInfo']['priceRanges']);
                }
                // 可售数量
                $product_arr['amount_on_sale'] = $product_information['productInfo']['saleInfo']['amountOnSale'];
                // 计量单位
                $product_arr['unit'] = $product_information['productInfo']['saleInfo']['unit'];
                // 最小起订量，范围是1-99999。
                $product_arr['min_order_quantity'] = $product_information['productInfo']['saleInfo']['minOrderQuantity'];
                // 每批数量，默认为空或者非零值，该属性不为空时sellunit为必填
                $product_arr['batch_number'] = isset($product_information['productInfo']['saleInfo']['batchNumber']) ?
                    $product_information['productInfo']['saleInfo']['batchNumber'] : 0;
                // 售卖单位，如果为批量售卖，代表售卖的单位，该属性不为空时batchNumber为必填，例如1"手"=12“件"的"手"
                $product_arr['sell_unit'] = isset($product_information['productInfo']['saleInfo']['sellunit']) ?
                    $product_information['productInfo']['saleInfo']['sellunit'] : '';
                // 0-无SKU按数量报价,1-有SKU按规格报价,2-有SKU按数量报价
                $product_arr['quote_type'] = $product_information['productInfo']['saleInfo']['quoteType'];
                // 分销基准价。代销场景均使用该价格。有SKU商品查看skuInfo中的consignPrice
                $product_arr['consign_price'] = isset($product_information['productInfo']['saleInfo']['consignPrice']) ?
                    $product_information['productInfo']['saleInfo']['consignPrice'] : '0.00';
                // CPS建议价（单位：元)
                $product_arr['cps_suggest_price'] = isset($product_information['productInfo']['saleInfo']['cpsSuggestPrice']) ?
                    $product_information['productInfo']['saleInfo']['cpsSuggestPrice'] : '0.00';
                //厂货通渠道专享价（单位：元）
                $product_arr['channel_price'] = isset($product_information['productInfo']['saleInfo']['channelPrice']) ?
                    $product_information['productInfo']['saleInfo']['channelPrice'] : '0.00';
            }

            // 运费模版
            if (isset($product_information['productInfo']['shippingInfo']) && !empty($product_information['productInfo']['shippingInfo'])
            ) {
                // 商品运费费率
                if (isset($product_information['productInfo']['shippingInfo']['freightTemplate']) &&
                    !empty($product_information['productInfo']['shippingInfo']['freightTemplate'])
                ) {
                    foreach ($product_information['productInfo']['shippingInfo']['freightTemplate'] as $f) {
                        $addressCodeText = $f['addressCodeText'];

                        foreach ($f['expressSubTemplate']['rateList'] as $rate) {
                            array_push($shipping_arr, [
                                'product_id' => $product_information['productInfo']['productID'],
                                'unit_weight' => isset($product_information['productInfo']['shippingInfo']['unitWeight']) ?
                                    $product_information['productInfo']['shippingInfo']['unitWeight'] : '',
                                'send_goods_address_id' => $product_information['productInfo']['shippingInfo']['sendGoodsAddressId'],
                                'send_goods_address_text' => $addressCodeText,
                                'suttle_weight' => isset($product_information['shippingInfo']['suttleWeight']) ? $product_information['shippingInfo']['suttleWeight'] : 0.00,
                                'width' => isset($product_information['shippingInfo']['width']) ? $product_information['shippingInfo']['width'] : 0.00,
                                'height' => isset($product_information['shippingInfo']['height']) ? $product_information['shippingInfo']['height'] : 0.00,
                                'length' => isset($product_information['shippingInfo']['length']) ? $product_information['shippingInfo']['length'] : 0.00,
                                'to_area_code_text' => $rate['toAreaCodeText'],
                                'first_unit' => $rate['rateDTO']['firstUnit'],
                                'first_unit_fee' => $rate['rateDTO']['firstUnitFee'],
                                'next_unit' => $rate['rateDTO']['nextUnit'],
                                'next_unit_fee' => $rate['rateDTO']['nextUnitFee'],
                                'channel_price_free_postage' => isset($product_information['channelPriceFreePostage']) ? $product_information['channelPriceFreePostage'] : 0.00,
                                'channel_price_exclude_areaCodes' => isset($product_information['shippingInfo']['channelPriceExcludeAreaCodes']) ?
                                    json_encode($product_information['shippingInfo']['channelPriceExcludeAreaCodes']) : ''
                            ]);
                        }
                    }
                }
            }

            // 产品属性列表
            if (isset($product_information['productInfo']['attributes']) &&
                !empty($product_information['productInfo']['attributes'])
            ) {
                foreach ($product_information['productInfo']['attributes'] as $attributes_info) {
                    array_push($attribute_arr, [
                        'product_id' => $product_information['productInfo']['productID'],
                        'attribute_id' => $attributes_info['attributeID'],
                        'attribute_name' => $attributes_info['attributeName'],
                        'value_id' => isset($attributes_info['valueID']) ? $attributes_info['valueID'] : 0,
                        'value' => isset($attributes_info['value']) ? $attributes_info['value'] : '',
                        'is_custom' => $attributes_info['isCustom'] === true ? 1 : 0,
                    ]);
                }
            }

            // sku信息
            if (isset($product_information['productInfo']['skuInfos']) && !empty($product_information['productInfo']['skuInfos'])) {
                foreach ($product_information['productInfo']['skuInfos'] as $sku_info) {
                    // 商品与sku对应信息表的数据
                    array_push($product_sku_arr, [
                        // skuId,该规格在所有商品中的唯一标记
                        'sku_id' =>  $sku_info['skuId'],
                        // 商品编号
                        'product_id' => $product_id,
                        // specId,该规格在本商品内的唯一标记
                        'spec_id' =>  $sku_info['specId'],
                        // 指定规格的货号
                        'cargo_number' =>  $sku_info['cargoNumber'],
                        // 可销售数量
                        'amount_on_sale' =>  $sku_info['amountOnSale'],
                        // 建议零售价
                        'retail_price' =>  isset($sku_info['retailPrice']) ? $sku_info['retailPrice'] : 0.00,
                        // 报价时该规格的单价
                        'price' =>  isset($sku_info['price']) ? $sku_info['price'] : 0.00,
                        // 分销基准价。代销场景均使用该价格。无SKU商品查看saleInfo中的consignPrice
                        'consign_price' => isset($sku_info['consignPrice']) ? $sku_info['consignPrice'] : 0.00,
                        // attribute_id
                        'attribute_id' => implode(',', array_column($sku_info['attributes'], 'attributeID'))
                    ]);

                    // sku信息
                    foreach ($sku_info['attributes'] as $attribute) {
                        if (empty($match_sku_id_arr) || (!empty($match_sku_id_arr) && ! in_array($attribute['attributeValue'], $match_sku_id_arr))) {
                            array_push($sku_arr, [
                                // sku属性ID
                                'attribute_id' => $attribute['attributeID'],
                                // sku值内容
                                'attribute_value' => $attribute['attributeValue'],
                                // sku属性ID所对应的显示名，比如颜色，尺码
                                'attribute_display_name' => isset($attribute['attributeDisplayName']) ? $attribute['attributeDisplayName'] : '',
                                // sku属性ID所对应的显示名，比如颜色，尺码
                                'attribute_name' => $attribute['attributeName'],
                                // sku图片名
                                'sku_image_url' => isset($attribute['skuImageUrl']) ? $attribute['skuImageUrl'] : '',
                            ]);
                            array_push($match_sku_id_arr, $attribute['attributeValue']);
                        }
                    }
                }
            }
        }

//        return [$sku_arr, $product_sku_arr, $sale_info_arr, $shipping_arr, $freight_arr, $attribute_arr];
        return [$product_arr, $sku_arr, $product_sku_arr, $shipping_arr, $freight_arr, $attribute_arr];

    }

    static public function queryProductOfferDetailActivity($product_id) {
        $ali = new AliOpen();
        $ali->params = ['offerId' => $product_id];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = "http://www.ylmall.com/common/alibabatest/queryOfferDetailActivity";

        $resp = $ali->product->productCpsMediaProductInfo();

        var_dump($resp);
        exit();

        $promotion_arr = [];
        if ($resp['result']['offerId'] == $product_id) {
            list($datetime, $hour) = explode('+', $resp['result']['startTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $start_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['hotTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $hot_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['endTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $end_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['freepostageStartTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $free_postage_start_time = date("Y-m-d H:i:s", $datetime);

            list($datetime, $hour) = explode('+', $resp['result']['freepostageEndTime']);
            $datetime = strlen($datetime) == 14 ? strtotime($datetime) : strtotime(substr($datetime, 0, 14));
            $free_postage_end_time = date("Y-m-d H:i:s", $datetime);

            $promotion_arr['category_id'] = $resp['result']['offerId'];
            $promotion_arr['activity_id'] = $resp['result']['activityId'];
            $promotion_arr['activity_name'] = $resp['result']['activityName'];
            // 预热时间,活动未开始,不可用活动价下单; 为null表示无预热时间
            $promotion_arr['hot_time'] = $hot_time;
            // 活动开始时间；大于now时，活动有效
            $promotion_arr['start_time'] = $start_time;
            // 活动结束时间；小于now时，活动有效
            $promotion_arr['end_time'] = $end_time;
            // 活动起批量
            $promotion_arr['begin_quantity'] = $resp['result']['beginQuantity'];
            // 活动总库存，为null时使用offer原库存
            $promotion_arr['stock'] = $resp['result']['stock'];
            // 商品本身限购数，非活动价可购买数；-1表示不限，0表示可购买数为0；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_arr['person_limit_count'] = $resp['result']['personLimitCount'];
            // 限购数，等于0且personLimitCount>0时，可以以原价下单，但不能以活动价下单；-1表示不限数量；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_arr['promotion_limit_count'] = $resp['result']['promotionLimitCount'];
            // 活动限购数；该场内活动商品限购数，-1表示不限购；0表示不可购买该场活动所有商品；3个*LimitCount字段都等于-1时，表示没有任何限购
            $promotion_arr['activity_limit_count'] = $resp['result']['activityLimitCount'];
            // 活动限时包邮开始时间；null 表示不限时
            $promotion_arr['free_postage_start_time'] = $free_postage_start_time;
            // 活动限时包邮结束时间；null 表示不限时
            $promotion_arr['free_postage_end_time'] = $free_postage_end_time;
            // 免包邮地区，与活动包邮配合使用
            $promotion_arr['exclude_area_list'] = json_encode($resp['result']['excludeAreaList']);
            // 如果offer是范围报价，且价格优惠是折扣的情况，返回折扣计算后的价格范围;优先取该字段，该字段为空时，表示分sku报价，取promotionItemList
            $promotion_arr['range_price'] = json_encode($resp['result']['rangePrice']);
            // 优惠结果，根据优惠方式（PromotionInfo），结合offer的原价信息，计算出优惠结果：每个sku或者每个区间价的促销价，折扣率
            $promotion_arr['promotion_item_list'] = json_encode($resp['result']['promotionItemList']);
            // sku维度的库存结果
            $promotion_arr['sku_stock_list'] = json_encode($resp['result']['skuStockList']);
            $promotion_arr['intro_order_flow'] = $resp['result']['introOrderFlow'];
        }

        return $promotion_arr;
    }

    /**
     * 获取商品分类信息
     * @param $category_id
     * @return mixed
     */
    static public function getCategoryFrom1688Api($category_id) {
        $ali = new AliOpen();
        $ali->params = ['categoryID' => $category_id];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);
        return $ali->category->categoryGet()->getResp();
    }

    /**
     * 传入商品分类编号，获取其下级商品分类，直至子叶级分类
     * @param int $category_id
     * @param array $parent_result
     * @return array|mixed
     */
    static public function getSubCategoryById($category_id = 0, $parent_result = []) {
        list($sub_id_arr, $result) = self::getCategoryFrom1688Api($category_id);

        if (!empty($result)) {
            if (!empty($parent_result)) {
                foreach ($parent_result as $idx => $category_info) {
                    if ($category_info['id'] == $result[0]['id']) {
                        unset($parent_result[$idx]);
                    }
                }
            }
            $result = !empty($parent_result) ? array_merge($parent_result, $result) : $result;
        }

        // 还有叶级分类需要获取
        if (!empty($sub_id_arr)) {
            foreach ($sub_id_arr as $idx => $sub_id)
                $result = self::getSubCategoryById($sub_id, $result);
        }

        return $result;
    }

    static public function getProductFollow($product_id = 0)
    {

        $ali         = new AliOpen();
        $ali->params = ['productId' => $product_id];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = Registry::get('config')['application']['host'] . "/common/alibabatest/follow";

        try {
            $resp = $ali->product->productFollow();
            // 日志记录$resp
            return $resp['message'] === 'success';
        } catch (ylAlibabaException $e) {
            throw $e;
        }
    }

    static public function unFollowProduct($product_id = 0)
    {

        $ali         = new AliOpen();
        $ali->params = ['productId' => $product_id];
        $ali->setAppKey(static::APP_KEY);
        $ali->setAppSecret(static::APP_SECRET);

        // 测试时使用本地接口 正式接口调用时 注释掉下面两行
//        $ali->product->setMode('development');
//        $ali->product->res_url = Registry::get('config')['application']['host'] . "/common/alibabatest/follow";

        try {
            $resp = $ali->product->productUnFollow();
            // 日志记录$resp
            return $resp['message'] === 'success';
        } catch (ylAlibabaException $e) {
            throw $e;
        }
    }
}


