<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 05/07/2018
 * Time: 2:30 AM
 */

namespace App\Traits;

trait HydratingTraits
{


    public static function hydrate(array $resultSet)
    {
        $class = get_called_class();
        $obj = new $class();
        foreach ($resultSet as $column => $value)
        {

            $obj->$column = $value;
        }


        return $obj;
    }

    public function extract()
    {
        return call_user_func('get_object_vars', $this);
    }
}
