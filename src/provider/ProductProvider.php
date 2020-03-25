<?php


namespace ylAlibaba\provider;


use ylAlibaba\core\Container;
use ylAlibaba\functions\product\Category;
use ylAlibaba\functions\product\Product;
use ylAlibaba\interfaces\Provider;


class ProductProvider implements Provider
{
    public function serviceProvider(Container $container) {
        $container['product'] = function ($container){
            return new Product($container);
        };
    }
}
