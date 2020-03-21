<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;
use ylAlibaba\core\ylAlibabaException;

/**
 * Class Category
 * @package ylAlibaba\functions\product
 */
class Category extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";
    /**
     * 订单列表
     * @return $this
     */
    public function categoryGet()
    {
        $this->url_info = 'com.alibaba.product:alibaba.category.get-1';

        return $this;
    }

    /**
     * 获取返回结果
     * @return array
     * @throws ylAlibabaException
     */
    public function getResp() {
        $resp = $this->post();

        $sub_id_arr = $result = [];
        if (! isset($resp['succes']) || $resp['succes'] != 'true') {
            $msg = $this->url_info . self::ERR_MSG;
            foreach ($resp as $idx => $value) {
                if (strpos($msg, '#' . $idx . '#') !== false)
                    $msg = str_replace('#' . $idx . '#', $value, $msg);
            }
            throw new ylAlibabaException($msg);
        } else {
            if ($resp['categoryInfo'][0]['categoryID'] === $this->app->params['categoryID']) {
                if ($resp['categoryInfo'][0]['isLeaf'] === true && empty($resp['categoryInfo'][0]['childCategorys'])) {
                    array_push($result, ['id' => $resp['categoryInfo'][0]['categoryID'], 'parent' => $resp['categoryInfo'][0]['parentIDs'][0],
                        'name' => $resp['categoryInfo'][0]['name'], 'publishing' => 1,
                        'min_order_quantity' => $resp['categoryInfo'][0]['minOrderQuantity']]);
                } else {
                    foreach ($resp['categoryInfo'][0]['childCategorys'] as $category_info) {
                        array_push($sub_id_arr, $category_info['id']);
                        array_push($result, ['id' => $category_info['id'], 'parent' => $this->app->params['categoryID'],
                            'name' => $category_info['name'], 'publishing' => $resp['categoryInfo'][0]['isLeaf'] === true ? 1 : 0,
                            'min_order_quantity' => $resp['categoryInfo'][0]['minOrderQuantity']]);
                    }
                }
            }
        }

        return [$sub_id_arr, $result];
    }
}
