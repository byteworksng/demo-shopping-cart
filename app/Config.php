<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 04/07/2018
 * Time: 10:23 PM
 */

namespace App;

class Config implements \ArrayAccess
{

    private $options;

    public function __construct($options)
    {
        foreach ($options as $key => $value)
        {
            $this->offsetSet($key, is_array($value) ? (object)$value : $value);
        }
    }

    public function get($option)
    {
        if ( ! $this->offsetExists($option))
        {
            return null;
        }
        return $this->offsetGet($option);
    }

    public function offsetExists($offset)
    {
        return isset($this->options[$offset]);

    }

    public function offsetUnset($offset)
    {
        unset($this->options[$offset]);

    }

    public function offsetGet($offset)
    {
        return $this->options[$offset];

    }

    public function offsetSet($offset, $value)
    {
        $this->options[$offset] = $value;
    }
}
