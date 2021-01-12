<?php
/**
 * Created by PhpStorm.
 * User: zuhaili
 * Date: 02/05/2018
 * Time: 9:06 AM
 */

namespace Zuhaili92\Library;


use Carbon\Carbon;

class ParcelUtils
{
    public function date_parse($date, $format)
    {
        return Carbon::createFromFormat($format, $date);
    }
}