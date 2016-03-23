<?php

namespace Goqihoo\Aliyun\Ons;

use Goqihoo\Aliyun\Ons\Authorization;

abstract class AuthorizedClient
{

    /**
     * ONS server url
     *
     * @var string
     */
    public $url;

    /**
     * Request time
     *
     * @var double $time
     */
    public $time;

    /**
     * Aliyun Authorization
     *
     * @var Authorization
     */
    private $authorization;

    /**
     * Initialize
     *
     * @param string $url
     * @param Authorization $authorization
     */
    public function __construct($url, Authorization $authorization)
    {
        $this->url = $url;
        $this->authorization;
    }

    /**
     * Get authorization from producer
     *
     * @return Authorization
     */
    public function getAuthorization()
    {
        return $this->authorization;
    }

    /**
     * Get microtime
     *
     * @return double
     */
    public function getTime()
    {
        list($usec, $sec) = explode(' ', microtime());
        return intval($usec * 1000) + $sec * 1000;
    }

    /**
     * Make request url
     *
     * @return string
     */
    public function makeRequestUrl()
    {
        return sprintf("%s?topic=%s&time=%d&type=http&key=http", $this->url, $this->topic, $this->time);
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    abstract public function getSignature();
}