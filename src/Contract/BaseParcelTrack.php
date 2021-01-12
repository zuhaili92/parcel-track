<?php
/**
 * Created by PhpStorm.
 * User: hafiq
 * Date: 01/05/2018
 * Time: 10:57 PM
 */

namespace Zuhaili92\ParcelTrack\Contract;

use Zuhaili92\ParcelTrack\Tracker\Abx;
use Zuhaili92\ParcelTrack\Tracker\BaseTracker;
use Zuhaili92\ParcelTrack\Tracker\CityLink;
use Zuhaili92\ParcelTrack\Tracker\DHL;
use Zuhaili92\ParcelTrack\Tracker\DHLCommerce;
use Zuhaili92\ParcelTrack\Tracker\FedEx;
use Zuhaili92\ParcelTrack\Tracker\Gdex;
use Zuhaili92\ParcelTrack\Tracker\KTMD;
use Zuhaili92\ParcelTrack\Tracker\LELExpress;
use Zuhaili92\ParcelTrack\Tracker\PosLaju;
use Zuhaili92\ParcelTrack\Tracker\SkyNet;
use Zuhaili92\ParcelTrack\Tracker\UPS;
use Carbon\Carbon;

class BaseParcelTrack
{
    /** @var BaseTracker  **/
    protected $source = null;
    protected $trackingCode = null;

    public function postLaju()
    {
        $this->source = new PosLaju();
        return $this;
    }

    public function gdExpress()
    {
        $this->source = new Gdex();
        return $this;
    }

    public function abxExpress()
    {
        $this->source = new Abx();
        return $this;
    }

    public function dhlExpress()
    {
        $this->source = new DHL();
        return $this;
    }

    public function dhlCommerce()
    {
        $this->source = new DHLCommerce();
        return $this;
    }

    public function skyNet()
    {
        $this->source = new SkyNet();
        return $this;
    }

    public function cityLink()
    {
        $this->source = new CityLink();
        return $this;
    }

    public function fedEx()
    {
        $this->source = new FedEx();
        return $this;
    }

    public function lelExpress()
    {
        $this->source = new LELExpress();
        return $this;
    }

    public function ktmDelivery()
    {
        $this->source = new KTMD();
        return $this;
    }

    public function ups()
    {
        $this->source = new UPS();
        return $this;
    }

    protected function getWhichCourier()
    {
        $courier_matched = [];
        if (preg_match('/E\w*MY$/', $this->trackingCode)) {
            $courier_matched[] = (new PosLaju())->getSourceName();
        }

        if (preg_match('/^E.*\d$/', $this->trackingCode)) {
            $courier_matched[] = (new Abx())->getSourceName();
        }

        if (preg_match('/^MY.*\d$/', $this->trackingCode)) {
            $courier_matched[] = (new Gdex())->getSourceName();
        }

        if (preg_match('/MYM.\d*/', $this->trackingCode)) {
            $courier_matched[] = (new LELExpress())->getSourceName();
        }

        if (preg_match('/(1Z.\d{15})|\T\d{10}|\d{9,12}/', $this->trackingCode)) {
            $courier_matched[] = (new UPS())->getSourceName();
        }

        if (preg_match('/^\d{8,13}$/', $this->trackingCode)) {
            $courier_matched[] = (new Gdex())->getSourceName();
            $courier_matched[] = (new DHL())->getSourceName();
            $courier_matched[] = (new FedEx())->getSourceName();
            $courier_matched[] = (new SkyNet())->getSourceName();
            $courier_matched[] = (new KTMD())->getSourceName();
        }

        if (preg_match('/^\d*$/', $this->trackingCode) && strlen($this->trackingCode) >= 14) {
            $courier_matched[] = (new CityLink())->getSourceName();
            $courier_matched[] = (new DHLCommerce())->getSourceName();
        }

        return array_merge([
            'code' => 200,
            'error' => false,
            'possible_courier' => $courier_matched,
            'generated_at' => Carbon::now()->toDateTimeString(),
        ], $this->createFooterJson(false));
    }

    /**
     * Fetch content from the url using guzzle
     * @param array $requestBody
     * @return array|null
     */
    protected function execute($requestBody)
    {
        $result = parcel_request()
            ->baseUrl($this->source->getUrl())
            ->setMethod($this->source->getMethodCall())
            ->setHeader($this->source->getHeader())
            ->appendToResult($this->createFooterJson())
            ->setRequestBody($requestBody);

        if ($this->source->rawOutput()) {
            $result = $result->getRaw()->fetch();
        } else {
            $result = $result->fetch();
        }

        return $result;
    }

    /**
     * Append Info at the end of content result
     * @param bool $withSource
     * @return array
     */
    protected function createFooterJson($withSource = true)
    {
        if ($withSource) {
            return [
                'footer' => [
                    'source' => $this->source->getSourceName(),
                    'homepage' => $this->source->getUrl(),
                    'developer' => [
                        "name" => "Hafiq",
                        "homepage" => "https://github.com/Zuhaili92"
                    ]
                ]
            ];
        } else {
            return [
                'footer' => [
                    'developer' => [
                        "name" => "Hafiq",
                        "homepage" => "https://github.com/Zuhaili92"
                    ]
                ]
            ];
        }
    }
}