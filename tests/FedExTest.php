<?php
namespace Tests;

require_once __DIR__ .'/../vendor/autoload.php';

use Zuhaili92\ParcelTrack\Tracker\FedEx;
use PHPUnit\Framework\TestCase;

/**
* RequestTest.php
* to test function in Request class
*/
class FedExTest extends TestCase
{
    function testFedExSuccess()
    {
        $result = parcel_track()->fedEx()->setTrackingNumber("435171366301")->fetch();

        $this->assertTrue(true);
        $this->assertEquals(200, $result['code']);
    }

    function testFedExEmptySuccess()
    {
        $result = parcel_track()->fedEx()->setTrackingNumber("435171366301AA")->fetch();

        $this->assertTrue(count($result['tracker']['checkpoints']) == 0);
        $this->assertEquals(200, $result['code']);
    }

    function testFedExFailed()
    {
        $result = parcel_track()->setTrackingNumber("435171366301")->fetch();
        $this->assertTrue($result['error']);
        $this->assertEquals(400, $result['code']);
    }

    function testFedExCheckCarrier()
    {
        $result = parcel_track()->setTrackingNumber("435171366301")->checkCourier();
        $this->assertFalse($result['error']);
        $this->assertTrue(in_array((new FedEx())->getSourceName(), $result['possible_courier']));
    }
}