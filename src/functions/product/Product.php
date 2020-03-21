<?php


namespace ylAlibaba\functions\product;


use ylAlibaba\core\BaseClient;

class Product extends BaseClient
{
    const ERR_MSG = "报错[#error_code# - #error_message# - #exception#]";
    /**
     * 订单列表
     * @return $this
     */
    public function productFollow()
    {
        $this->url_info = 'com.alibaba.product:alibaba.product.follow-1';

        return $this;
    }

}
