<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;

class Consumer extends AuthorizedClient
{

    /**
     * ConsumerId on Aliyun
     *
     * @var string $consumerId
     */
    public $consumerId;

    /**
     * consume message from ONS
     *
     * @param string $topic
     * @param string $consumerId
     * @return boolean
     */
    public function consume($topic, $consumerId)
    {
        $this->time         = $this->getTime();
        $this->topic        = $topic;
        $this->consumerId   = $consumerId;
        $client = new HttpClient();
        $request = $client->post($this->makeRequestUrl());
        $request->addHeader('AccessKey', $this->getAuthorization()->getAccessKey())
            ->addHeader('Signature', $this->getSignature())
            ->addHeader('ConsumerId', $this->consumerId);
        return $request->send();
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    public function getSignature()
    {
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->consumerId, $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessKey(), true));
    }
}
