<?php
/**
 * Author: Arjhay Delos Santos
 * Date: 8/23/2017
 * Time: 6:18 PM
 */

namespace DevArjhay\Honeypot;

use Illuminate\Support\Facades\Crypt;

class Honeypot
{
    /**
     * @var mixed
     */
    protected $enabled;

    /**
     * @var mixed
     */
    protected $auto_complete;

    /**
     * Honeypot constructor.
     */
    public function __construct()
    {
        $this->enabled = config('honeypot.enabled');
        $this->auto_complete = config('honeypot.auto_complete');
    }

    /**
     * Make a new honeypot and return the HTML form.
     *
     * @param $name
     * @param $time
     * @return string
     */
    public function make($name, $time)
    {
        $encrypted = $this->getEncryptedTime();
        $html = '<div id="' . $name . '_wrap" style="display: none;">' . "\r\n" .
                    '<input type="text" name="' . $name . '" id="' . $name . '" value="" autocomplete="' . $this->auto_complete . '">' . "\r\n" .
                    '<input type="text" name="' . $time . '" id="' . $time . '" value="' . $encrypted .'" autocomplete="' . $this->auto_complete . '">' . "\r\n" .
                '</div>';
        return $html;
    }

    /**
     * Validate honeypot if empty.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateHoneypot($attribute, $value, $parameters)
    {
        if (!$this->enabled) {
            return true;
        }
        return $value == '';
    }

    /**
     * Validate honey time withing the time limit.
     *
     * @param $attribute
     * @param $value
     * @param $parameters
     * @return bool
     */
    public function validateHoneytime($attribute, $value, $parameters)
    {
        if (!$this->enabled) {
            return true;
        }

        // Get the decrypted time.
        $value = $this->decryptTime($value);

        // The current time should be greater than the time the form was built + the speed option.
        return (is_numeric($value) && time() > ($value + $parameters[0]));
    }

    /**
     * Get the encrypted time.
     *
     * @return mixed
     */
    public function getEncryptedTime()
    {
        return Crypt::encrypt(time());
    }

    /**
     * Decrypt the given time.
     *
     * @param $time
     * @return null
     */
    public function decryptTime($time)
    {
        try {
            return Crypt::decrypt($time);
        } catch (\Exception $exception) {
            return null;
        }
    }
}