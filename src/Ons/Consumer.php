<?php

namespace Goqihoo\Aliyun\Ons;

use Guzzle\Http\Client as HttpClient;
use GuzzleHttp\Psr7\Request;

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
     * @return Response
     */
    public function consume($topic = '', $consumerId = '')
    {
        $this->time         = $this->getTime();
        $this->topic        = $topic;
        $this->consumerId   = $consumerId;
        $client = $this->getHttpClinet();
        $request = new Request('GET', $this->makeRequestUrl(), array(
            'AccessKey'  => $this->getAuthorization()->getAccessKey(),
            'Signature'  => $this->getSignature(),
            'ConsumerId' => $this->consumerId,
        ));
        $response = $client->send($request);
        return new Response($response);
    }

    /**
     * Make signature for authorized request
     *
     * @return string
     */
    public function getSignature()
    {
        $signString= sprintf("%s\n%s\n%d", $this->topic, $this->consumerId, $this->time);
        return base64_encode(hash_hmac('sha1', $signString, $this->getAuthorization()->getAccessSecret(), true));
    }
}
