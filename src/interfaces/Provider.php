<?php


namespace ylAlibaba\interfaces;


use ylAlibaba\core\Container;

/**
 * Interface Provider
 * @package ylAlibaba\interfaces
 */
interface Provider
{
    public function serviceProvider(Container $container);

}
