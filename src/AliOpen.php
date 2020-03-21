<?php


namespace ylAlibaba;


use ylAlibaba\core\ContainerBase;
use ylAlibaba\provider\CategoryProvider;

/**
 * Class AliOpen
 * @package ylAlibaba
 * @property CategoryProvider category
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
        CategoryProvider::class
        //...其他服务提供者
    ];
}
