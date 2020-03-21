<?php


namespace ylAlibaba\core;


/**
 * Class ContainerBase
 * @package ylAlibaba\core
 */
class ContainerBase extends Container
{
    protected $provider = [];

    public $params = [];

    public $base_url;

    public $app_key = '';

    public $app_secret = '';

    public $access_token = '';

    public function __construct($params =array())
    {
        $this->params = $params;

        $provider_callback = function ($provider) {
            $obj = new $provider;
            $this->serviceRegister($obj);
        };
        //注册
        array_walk($this->provider, $provider_callback);
    }

    public function __get($id) {
        return $this->offsetGet($id);
    }

    /**
     * @param mixed $app_secret
     */
    public function setAppSecret($app_secret) {
        $this->app_secret = $app_secret;
    }

    /**
     * @param mixed $app_key
     */
    public function setAppKey($app_key) {
        $this->app_key = $app_key;
    }
}
