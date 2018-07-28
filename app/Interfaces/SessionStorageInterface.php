<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 3:08 PM
 */

namespace App\Interfaces;

interface SessionStorageInterface
{
    public function setStoragePath($path = null);

    public function insert($key, array $value, $closeSession);

    public function update($key, array $value, $closeSession);

    public function query($key, array $param = null);

    public function remove($key, $param = null, $shouldCloseSession = false);

}
