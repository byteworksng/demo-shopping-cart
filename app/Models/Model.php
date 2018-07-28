<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 07/07/2018
 * Time: 1:49 AM
 */

namespace App\Models;


use App\Interfaces\ModelInterface;
use App\Traits\HydratingTraits;

class Model implements ModelInterface
{
    use HydratingTraits;


    public function __call($name, $arguments)
    {
        if ( ! method_exists($this, $name))
        {
            throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
        } else
        {
            return self::$name($arguments);
        }

    }


    public function __set($name, $value)
    {
        // blocks dynamic setting of variables...
    }
}
