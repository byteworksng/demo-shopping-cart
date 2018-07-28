<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 02/07/2018
 * Time: 11:06 PM
 */

namespace App\Interfaces;

interface DbConnectionInterface
{
    public static function getConnection();

    public function execute($sql, array $args = null);
}
