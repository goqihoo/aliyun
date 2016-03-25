<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Authorization;
use Goqihoo\Aliyun\Ons\Producer;

class ProducerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Provide data for producer
     *
     * @return array
     */
    public function getMessageQueueInfo()
    {
        return array(
            array(
                'http://publictest-rest.ons.aliyun.com/message/',
                'huxiu_log_test',
                'PID_huxiu_log',
                'test_producer',
                '', //your real accessKey
                '', //your real accessSecret
            ),
        );
    }

    /**
     * Provide data for signature method test
     */
    public function getSignatureInfo()
    {
        return array(
            array(
                'http://publictest-rest.ons.aliyun.com/message/',
                'TopicTest',
                'PID_test',
                'aaaaa',
                'AccessKey',
                'SecretAccessKey',
                '1456953521432',
            ),
        );
    }

    /**
     * Test getSignature method
     *
     * @param string $url
     * @param string $topic
     * @param string $producerId
     * @param string $body
     * @param string $accessKey
     * @param string $accessSecret
     * @param int $time
     * @dataProvider getSignatureInfo
     */
    public function testGetSignature($url, $topic, $producerId, $body, $accessKey, $accessSecret, $time)
    {
        $sign = "w3zcLtNkj/+virVsjDbFbxKri8Q=";
        $authorization = new Authorization($accessKey, $accessSecret);
        $producer = new Producer('', $authorization);
        $producer->setBody($body)
                 ->setTopic($topic)
                 ->setProducerId($producerId)
                 ->setTime($time);
        $this->assertEquals($sign, $producer->getSignature());
    }

    /**
     * Test produce method
     *
     * @param string $url
     * @param string $topic
     * @param string $producerId
     * @param string $body
     * @param string $accessKey
     * @param string $accessSecret
     * @dataProvider getMessageQueueInfo
     */
    public function testProduce($url, $topic, $producerId, $body, $accessKey, $accessSecret)
    {
        $authorization = new Authorization($accessKey, $accessSecret);
        $producer = new Producer($url, $authorization);
        $response = $producer->produce($topic, $producerId, $body);
        $this->assertTrue($response->isSuccessful());
    }
}
