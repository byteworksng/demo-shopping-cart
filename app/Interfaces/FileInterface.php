<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 05/07/2018
 * Time: 7:55 PM
 */

namespace App\Interfaces;

interface FileInterface
{
    /**
     * loads and executes file from filesystem
     *
     * @param string $file
     * @param array  $params
     *
     * @return string
     */
    function loadFile($file, array $params = []);

    /**
     * @param $file
     *
     * @return string
     */
    function locateFile($file);
}
