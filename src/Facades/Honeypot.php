<?php
/**
 * Author: Arjhay Delos Santos
 * Date: 8/23/2017
 * Time: 7:23 PM
 */

namespace DevArjhay\Honeypot\Facades;

use Illuminate\Support\Facades\Facade;

class Honeypot extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'honeypot';
    }
}