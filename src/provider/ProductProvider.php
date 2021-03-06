<?php


namespace ylAlibaba\provider;


use ylAlibaba\core\Container;
use ylAlibaba\functions\product\Product;
use ylAlibaba\interfaces\Provider;

/**
 * Class ProductProvider
 * @package ylAlibaba\provider
 */
class ProductProvider implements Provider
{
    public function serviceProvider(Container $container) {
        $container['product'] = function ($container){
            return new Product($container);
        };
    }
}
