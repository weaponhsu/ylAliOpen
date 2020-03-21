<?php


namespace ylAlibaba\provider;


use ylAlibaba\core\Container;
use ylAlibaba\functions\product\Category;
use ylAlibaba\interfaces\Provider;

/**
 * Class CategoryProvider
 * @package ylAlibaba\provider
 */
class CategoryProvider implements Provider
{
    public function serviceProvider(Container $container) {
        $container['category'] = function ($container){
            return new Category($container);
        };
    }
}
