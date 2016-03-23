<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;

class Producer extends AuthorizedClient
{

    /**
     * Message body
     *
     * @var string
     */
    private $body;

    /**
     * Topic for ONS
     *
     * @var string $topic
     */
    public $topic;

    /**
     * ProducerID for ONS
     *
     * @var string $pic
     */
    public $producerId;

    /**
     * send message to ONS
     *
     * @param string $topic
     * @param string $producerId
     * @param string $body
     * @return boolean
     */
    public function produce($topic, $producerId, $body)
    {
        $this->time         = $this->getTime();
        $this->topic        = $topic;
        $this->producerId   = $producerId;
        $client = new HttpClient();
        $request = $client->post($this->makeRequestUrl(), array(), $body);
        $request->addHeader('AccessKey', $this->getAuthorization()->getAccessKey())
                ->addHeader('Signature', $this->getSignature())
                ->addHeader('ProducerId', $this->producerId);
        return new Response($request->send());
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    public function getSignature()
    {
        $signString= sprintf("%s\n%s\n%s\n%d", $this->topic, $this->producerId, md5($this->body), $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessKey(), true));
    }
}

