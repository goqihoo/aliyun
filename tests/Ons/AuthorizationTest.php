<?php

namespace Goqihoo\Aliyun\Tests\Ons;

use Goqihoo\Aliyun\Ons\Authorization;

class AuthorizationTest extends \PHPUnit_Framework_TestCase
{

    public function getAuthorizationInfo()
    {
        return array(
            array('abcd', 'test_secret'),
        );
    }

    /**
     * @dataProvider getAuthorizationInfo
     */
    public function testAuthorization($accessKey, $accessSecret)
    {
        $authorization = new Authorization($accessKey, $accessSecret);

        $this->assertEquals($accessKey, $authorization->getAccessKey());
        $this->assertEquals($accessSecret, $authorization->getAccessSecret());
    }
}