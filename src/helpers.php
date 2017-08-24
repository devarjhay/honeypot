<?php
/**
 * Author: Arjhay Delos Santos
 * Date: 8/24/2017
 * Time: 12:10 PM
 */

use DevArjhay\Honeypot\Facades\Honeypot;

if (!function_exists('honeypot'))
{
    function honeypot($name, $time)
    {
        return Honeypot::make($name, $time);
    }
}
