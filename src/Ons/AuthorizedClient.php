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
     * Topic for ONS
     *
     * @var string $topic
     */
    public $topic;

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
        $this->authorization = $authorization;
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
     * Set produce time
     *
     * @param int $time
     * @return $this
     */
    public function setTime($time)
    {
        $this->time = $time;
        return $this;
    }

    /**
     * Set topic
     *
     * @param string $topic
     * @return $this
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;
        return $this;
    }

    /**
     * Make request url
     *
     * @return string
     */
    public function makeRequestUrl()
    {
        return sprintf("%s?topic=%s&time=%d&tag=http&key=http", $this->url, $this->topic, $this->time);
    }
}