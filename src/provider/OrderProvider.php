<?php


namespace ylAlibaba\provider;


use ylAlibaba\core\Container;
use ylAlibaba\functions\product\Order;
use ylAlibaba\interfaces\Provider;

/**
 * Class OrderProvider
 * @package ylAlibaba\provider
 */
class OrderProvider implements Provider
{
    public function serviceProvider(Container $container) {
        $container['order'] = function ($container){
            return new Order($container);
        };
    }

}
