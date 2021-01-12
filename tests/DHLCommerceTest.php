<?php
namespace Tests;

require_once __DIR__ .'/../vendor/autoload.php';

use Zuhaili92\ParcelTrack\Tracker\DHLCommerce;
use PHPUnit\Framework\TestCase;

/**
* RequestTest.php
* to test function in Request class
*/
class DHLCommerceTest extends TestCase
{
    function testDHLCommerceSuccess()
    {
        $result = parcel_track()->dhlCommerce()->setTrackingNumber("5218031053514008")->fetch();

        $this->assertTrue(true);
        $this->assertEquals(200, $result['code']);
    }

    function testDHLCommerceEmptySuccess()
    {
        $result = parcel_track()->dhlCommerce()->setTrackingNumber("521803105351400")->fetch();

        $this->assertTrue(count($result['tracker']['checkpoints']) == 0);
        $this->assertEquals(200, $result['code']);
    }

    function testDHLCommerceFailed()
    {
        $result = parcel_track()->setTrackingNumber("5218031053514008")->fetch();
        $this->assertTrue($result['error']);
        $this->assertEquals(400, $result['code']);
    }

    function testDHLCommerceCheckCarrier()
    {
        $result = parcel_track()->setTrackingNumber("5218031053514008")->checkCourier();
        $this->assertFalse($result['error']);
        $this->assertTrue(in_array((new DHLCommerce())->getSourceName(), $result['possible_courier']));
    }
}