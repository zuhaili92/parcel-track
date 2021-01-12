<?php

use Zuhaili92\Library\ApiRequest;
use Zuhaili92\Library\ParcelUtils;
use Zuhaili92\ParcelTrack\ParcelTrack;

define('PARCEL_METHOD_POST', 'POST');
define('PARCEL_METHOD_GET', 'GET');
define('PARCEL_METHOD_PATCH', 'PATCH');
define('PARCEL_METHOD_DELETE', 'DELETE');
define('PARCEL_USER_AGENT', 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_13_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36');

if (! function_exists('parcel_track')) {

    function parcel_track()
    {
        return new ParcelTrack();
    }
}

if (! function_exists('parcel_request')) {

    function parcel_request()
    {
        return new ApiRequest();
    }
}

if (! function_exists('parcel_utils')) {

    function parcel_utils()
    {
        return new ParcelUtils();
    }
}

if (! function_exists('trim_spaces')) {
    function trim_spaces($text)
    {
        return trim(preg_replace('/\s+/', ' ', $text));
    }
}

if (! function_exists('die_response')) {

    function die_response($message = "Something Went Wrong")
    {
        http_response_code(400);
        return [
            'code' => 400,
            'error' => true,
            'message' => $message
        ];
    }
}