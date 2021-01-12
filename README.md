# Parcel Tracker

[![Build Status](https://travis-ci.org/Zuhaili92/parcel-track.svg?branch=master)](https://travis-ci.org/Zuhaili92/parcel-track)
[![Coverage](https://img.shields.io/codecov/c/github/Zuhaili92/parcel-track.svg)](https://codecov.io/gh/Zuhaili92/parcel-track)
[![Packagist](https://img.shields.io/packagist/dt/Zuhaili92/parcel-track.svg)](https://packagist.org/packages/Zuhaili92/parcel-track)
[![Packagist](https://img.shields.io/packagist/v/Zuhaili92/parcel-track.svg)](https://packagist.org/packages/Zuhaili92/parcel-track)
[![Donate](https://img.shields.io/badge/Donate-PayPal-green.svg)](https://www.paypal.com/paypalme/mhi9388?locale.x=en_US)

Simple Parcel Tracker for Local Parcel Courier. 
Basically it just crawl the courier website or existing API. Need time to time to monitor web/api changes before failure happen.

<br>

BTW, Currently available (Successfully Scraped)
1. [Post Laju](https://www.poslaju.com.my/)
2. [GDEX](http://www.gdexpress.com/malaysia/home/)
3. [ABX Express](http://www.abxexpress.com.my/)
4. [DHL Express](https://www.logistics.dhl/my-en/home.html)
5. [DHL E-Commerce](https://www.logistics.dhl/my-en/home/our-divisions/ecommerce.html)
6. [SkyNet Express](http://www.skynet.com.my/)
7. [CityLink Express](http://www.citylinkexpress.com/MY/Consignment.aspx)
8. [FedEx Express](https://www.fedex.com/my/)
9. [LEL Express](http://www.lex.com.my/)
10. [KTM Distribution Sdn Bhd](http://www.ktmd.com.my/tracking/)
11. [UPS](https://wwwapps.ups.com/WebTracking/track)


Tested in PHP 7.1 Only

## Installation

#### Step 1: Install from composer
```
composer require Zuhaili92/parcel-track
```
Alternatively, you can specify as a dependency in your project's existing composer.json file
```
{
   "require": {
      "Zuhaili92/parcel-tracker": "^1.0"
   }
}
```

## Usage
After installing, you need to require Composer's autoloader and add your code.

```php
require_once __DIR__ .'/../vendor/autoload.php';
```

#### Sample for Post Laju
```php
$data = parcel_track()
	->postLaju()
	->setTrackingNumber("ER157080065MY")
	->fetch();
```

#### Sample for GDex
```php
$data = parcel_track()
	->gdex()
	->setTrackingNumber("4941410530")
	->fetch();
```

#### Sample for Abx Express
```php
$data = parcel_track()
	->abxExpress()
	->setTrackingNumber("EZP843055940197")
	->fetch();
```

#### Sample for DHL Express
```php
$data = parcel_track()
	->dhlExpress()
	->setTrackingNumber("5176011131")
	->fetch();
```

#### Sample for Check Which Carrier Tracking Number belongs to
```php
$data = parcel_track()
	->setTrackingNumber("5176011131")
	->checkCourier();
```

### Method
<table>
    <tr>
        <th>Method</th>
        <th>Param</th>
        <th>Description</th>
    </tr>
    <tr>
        <td>postLaju()</td>
        <td></td>
        <td>Post Laju Courier</td>
    </tr>
    <tr>
        <td>abxExpress()</td>
        <td></td>
        <td>Post Laju Courier</td>
    </tr>
    <tr>
        <td>dhlExpress()</td>
        <td></td>
        <td>DHL Express Courier</td>
    </tr>
    <tr>
        <td>dhlCommerce()</td>
        <td></td>
        <td>DHL E-Commerce Courier</td>
    </tr>
    <tr>
        <td>gdex()</td>
        <td></td>
        <td>GD Express Courier</td>
    </tr>
    <tr>
        <td>skyNet()</td>
        <td></td>
        <td>SkyNet Express Courier</td>
    </tr>
    <tr>
        <td>cityLink()</td>
        <td></td>
        <td>City Link Express Courier</td>
    </tr>
    <tr>
        <td>fedEx()</td>
        <td></td>
        <td>FedEx Express Courier</td>
    </tr>
    <tr>
        <td>lelExpress()</td>
        <td></td>
        <td>Lazada E-Logistic Courier</td>
    </tr>
    <tr>
        <td>ktmDelivery()</td>
        <td></td>
        <td>KTM Distribution Sdn Bhd</td>
    </tr> 
    <tr>
        <td>ups()</td>
        <td></td>
        <td>United Parcel Service Courier</td>
    </tr>    
    <tr>
        <td>setTrackingNumber($refNumber)</td>
        <td><code>String</code></td>
        <td>Enter the tracking number</td>
    </tr>
</table>


### Result

##### Checking Result
For checking which carrier response like below:
```json
{
    "code": 200,
    "error": false,
    "possible_carrier": [
        "ABX Express Sdn Bhd",
        "City Link Express"
    ],
    "generated_at": "2018-05-14 08:53:35",
    "footer": {
        "developer": {
            "name": "Hafiq",
            "homepage": "https://github.com/Zuhaili92"
        }
    }
}

```

##### Tracker Result
You should getting data tracker similarly like below:
```json
{
    "code": 200,
    "error": false,
    "tracker": {
        "tracking_number": "4941410530",
        "provider": "gdex",
        "delivered": true,
        "checkpoints": [
            {
                "date": "2016-11-30 17:41:10",
                "timestamp": 1480527670,
                "process": "Outbound from KBR station",
                "type": "item_received",
                "event": "Kota Bharu"
            },
            {
                "date": "2016-11-30 17:47:00",
                "timestamp": 1480528020,
                "process": "Picked up by courier",
                "type": "dispatch",
                "event": "Kota Bharu"
            },
            {
                "date": "2016-12-01 03:25:11",
                "timestamp": 1480562711,
                "process": "In transit",
                "type": "facility_process",
                "event": "Petaling Jaya"
            },
            {
                "date": "2016-12-01 10:00:16",
                "timestamp": 1480586416,
                "process": "Inbound to JHB station",
                "type": "facility_process",
                "event": "Johor Bharu"
            },
            {
                "date": "2016-12-02 10:10:00",
                "timestamp": 1480673400,
                "process": "Delivered",
                "type": "delivered",
                "event": "Sungai Tiram"
            }
        ]
    },
    "generated_at": "2018-05-03 02:07:20",
    "footer": {
        "source": "GD Express Sdn Bhd",
        "developer": {
            "name": "Hafiq",
            "homepage": "https://github.com/Zuhaili92"
        }
    }
}
```

## Todo
- Struggling for other Parcel Data
- Keep up to date if any parcel data changes

## Issue
- If Issue happen like the api always return empty [] after cross check with real site, just let me know =)

<br>
Pftt.. I just don't know why, the Travis CI is failed. It because of `gnutls_handshake() failed`. In my local env, all Test Unit <font style="color: green">Passed</font> . I disabled it first because always failing on travis-ci.org =)
<br>
## ChangeLog
- See changelog.md

## License
Licensed under the [MIT license](http://opensource.org/licenses/MIT)


### Donate
<a href="https://www.paypal.com/paypalme/mhi9388?locale.x=en_US"><img src="https://i.imgur.com/Y2gqr2j.png" height="40"></a>  
