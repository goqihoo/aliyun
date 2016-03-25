<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Authorization;
use Goqihoo\Aliyun\Ons\Consumer;

class ConsumerTest extends \PHPUnit_Framework_TestCase
{

    /**
     * Provide data for consumer
     *
     * @return array
     */
    public function getMessageQueueInfo()
    {
        return array(
            array(
                'http://publictest-rest.ons.aliyun.com/message/',
                'huxiu_log_test',
                'CID_huxiu_log_storage',
                '', //your real accessKey
                '', //your real accessSecret
            ),
        );
    }

    /**
     * Test consume method
     *
     * @param string $url
     * @param string $topic
     * @param string $consumerId
     * @param string $accessKey
     * @param string $accessSecret
     * @dataProvider getMessageQueueInfo
     */
    public function testConsume($url, $topic, $consumerId, $accessKey, $accessSecret)
    {
        $authorization = new Authorization($accessKey, $accessSecret);
        $consumer = new Consumer($url, $authorization);
        $response = $consumer->consume($topic, $consumerId);
        $this->assertTrue($response->isSuccessful());

        $body = $response->toArray();
        $this->assertEquals('test_producer', $body[0]['body']);
    }
}
