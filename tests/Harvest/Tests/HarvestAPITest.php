<?php

namespace Harvest\Tests;

use Harvest\HarvestAPI;

/**
 * HarvestAPI test cases
 */
class HarvestAPITest extends \PHPUnit_Framework_TestCase
{
    public function testNothing()
    {
        $this->assertTrue(true);
    }

    public function testInstance()
    {
        $this->assertInstanceOf('Harvest\HarvestAPI', new HarvestAPI());
    }

    public function testAPIProperties()
    {
        $api = new HarvestAPI();

        $api->setUser('your@email.com');
        $api->setPassword('password');
        $api->setAccount('account');

        $this->assertEquals('your@email.com', \PHPUnit_Framework_Assert::readAttribute($api, '_user'));
        $this->assertEquals('password', \PHPUnit_Framework_Assert::readAttribute($api, '_password'));
        $this->assertEquals('account', \PHPUnit_Framework_Assert::readAttribute($api, '_account'));
    }

    /**
     * @group internet
     */
    public function testClientsRetrieval()
    {
        $api = new HarvestAPI();
        $config = file_exists(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE']) ? json_decode(file_get_contents(BASE_PATH . DIRECTORY_SEPARATOR . $_SERVER['API_CONFIG_FILE'])) : array();

        if (!$config) {
            $this->markTestSkipped('No API config file present.');
        }

        $api->setUser($config->user);
        $api->setPassword($config->password);
        $api->setAccount($config->account);

        /** @var \Harvest\Model\Result $result */
        $result = $api->getClient(1300267);

        $this->assertInstanceOf('\Harvest\Model\Result', $result);

        $this->assertEquals(200, $result->get('code'));
        $this->assertNotEmpty($result->get('headers'));
        $this->assertNotEmpty($result->get('data'));
    }
}
