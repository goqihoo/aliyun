<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Ons\Authorization;
use Goqihoo\Aliyun\Ons\Confirmation;
use Goqihoo\Aliyun\Ons\Consumer;

class ConfirmationTest extends \PHPUnit_Framework_TestCase
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
                'xxSzlwZRUnNkiUNa', //your real accessKey
                'xLq4kUDWqBk7ITBpNd0FUxdxgm81Le', //your real accessSecret
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
    public function testConfirm($url, $topic, $consumerId, $accessKey, $accessSecret)
    {
        $authorization = new Authorization($accessKey, $accessSecret);
        $consumer = new Consumer($url, $authorization);
        $response = $consumer->consume($topic, $consumerId);
        $this->assertTrue($response->isSuccessful());

        $body = $response->toArray();
        foreach ($body as $msg) {
            $confirmation = new Confirmation($url, $authorization);
            $response = $confirmation->confirm($topic, $consumerId, $msg['msgHandle']);
            $this->assertTrue($response->isSuccessful());
        }
    }
}