<?php

namespace Harvest\Tests;

use Harvest\HarvestAPI;

/**
 * HarvestAPI test cases
 */
class HarvestAPITest extends \PHPUnit_Framework_TestCase
{
    public function testNothing() {
        $this->assertTrue(true);
    }

    public function testInstance() {
        $this->assertInstanceOf('Harvest\HarvestAPI', new HarvestAPI());
    }

    public function testAPIProperties() {
        $api = new HarvestAPI();

        $api->setUser('your@email.com');
        $api->setPassword('password');
        $api->setAccount('account');

        $this->assertEquals('your@email.com', \PHPUnit_Framework_Assert::readAttribute($api, '_user'));
        $this->assertEquals('password', \PHPUnit_Framework_Assert::readAttribute($api, '_password'));
        $this->assertEquals('account', \PHPUnit_Framework_Assert::readAttribute($api, '_account'));
    }
}
