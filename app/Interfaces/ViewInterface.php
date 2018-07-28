<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 05/07/2018
 * Time: 7:59 PM
 */

namespace App\Interfaces;

interface ViewInterface extends FileInterface
{
    /**
     * @return string
     */
    function getViewDir();

    /**
     * @param $dirName
     *
     * @return string
     */
    function getViewPath($dirName);

    /**
     * @param $dirName
     *
     * @return string
     */
    function getLayoutPath($dirName);
}
