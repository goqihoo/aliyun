<?php

namespace Goqihoo\Aliyun;

class Authorization
{

    /**
     * accessKey provider by Aliyun
     *
     * @var string
     */
    private $accessKey;

    /**
     * accessSecret provider by Aliyun
     *
     * @var string
     */
    private $accessSecret;

    /**
     * Initialize
     *
     * @param string $accessKey
     * @param string $accessSecret
     */
    public function __construct($accessKey, $accessSecret)
    {
        $this->accessKey = $accessKey;
        $this->accessSecret = $accessSecret;
    }

    /**
     * Get accessKey
     *
     * @return string
     */
    public function getAccessKey()
    {
        return $this->accessKey;
    }

    /**
     * Get accessSecret
     *
     * @return string
     */
    public function getAccessSecret()
    {
        return $this->accessSecret;
    }
}

