<?php


namespace ylAlibaba\provider;


use ylAlibaba\core\Container;
use ylAlibaba\functions\product\Delivery;
use ylAlibaba\interfaces\Provider;


/**
 * Class DeliveryProvider
 * @package ylAlibaba\provider
 */
class DeliveryProvider implements Provider
{
    public function serviceProvider(Container $container) {
        $container['delivery'] = function ($container){
            return new Delivery($container);
        };
    }
}
