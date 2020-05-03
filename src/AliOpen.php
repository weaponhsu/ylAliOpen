<?php


namespace ylAlibaba;


use ylAlibaba\core\ContainerBase;
use ylAlibaba\provider\CategoryProvider;
use ylAlibaba\provider\OrderProvider;
use ylAlibaba\provider\ProductProvider;

/**
 * Class AliOpen
 * @package ylAlibaba
 * @property CategoryProvider category
 * @property ProductProvider product
 */
class AliOpen extends ContainerBase
{
    /**
     * 服务提供者
     * @var array
     */
    public function __construct($params = array())
    {
        parent::__construct($params);
    }

    protected $provider = [
        CategoryProvider::class,
        ProductProvider::class,
        OrderProvider::class
        //...其他服务提供者
    ];
}
