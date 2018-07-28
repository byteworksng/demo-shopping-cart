<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 07/07/2018
 * Time: 5:24 AM
 */

namespace App\Facade;


class Db extends Facade
{
    public static function getInstanceName()
    {
        return 'config';
    }
}
