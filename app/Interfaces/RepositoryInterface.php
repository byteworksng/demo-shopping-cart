<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 09/07/2018
 * Time: 2:25 PM
 */

namespace App\Interfaces;

/**
 * Interface RepositoryInterface
 *
 * @package App\Interfaces
 */
interface RepositoryInterface
{
    /**
     * retrieves records by param
     *
     * @param array $param
     *
     * @return mixed
     */
    function fetch($param);

    /**
     * retrieves all records
     *
     * @return mixed
     */
    function fetchAll();

    /**
     * Adds to record
     *
     * @param array $param
     * @param $shouldCloseSession
     * @return mixed
     */
    function add(array $param, $shouldCloseSession = false);

    /**
     * remove records by param
     *
     * @param array $param
     *
     * @return mixed
     */
    function remove($param);

    /**
     * removes all records
     *
     * @return mixed
     */
    function removeAll();


    /**
     * update records by param
     *
     * @param array $param
     *
     * @return mixed
     */
    function update($param, $shouldCloseSession = false);


}
