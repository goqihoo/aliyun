<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Authorization;
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
                'aliyun_ons_test',
                'CID-ons-test',
                'joU9edIYoFoX6WpG', //your real accessKey
                'jEWhZXsPDHqPh6A4I2Io9QYup10Uce', //your real accessSecret
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

        $messages = $response->getMessages();
        foreach ($messages as $message) {
            $confirmation = new Confirmation($url, $authorization);
            $response = $confirmation->confirm($topic, $consumerId, $message);
            $this->assertTrue($response->isSuccessful());
        }
    }
}