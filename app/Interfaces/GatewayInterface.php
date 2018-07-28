<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 1:08 AM
 */

namespace App\Interfaces;

/**
 * Interface GatewayInterface
 *
 * @package App\Interfaces
 */
interface GatewayInterface
{
    /**
     * @return mixed
     */
    public function getTable();

    /**
     * add a new record
     *  $set must be an assoc array
     *
     * @param array $set
     *
     * @return mixed
     */
    public function insert(array $set);

    /**
     * update  a existing record
     *
     * @param array $set
     *
     * @return mixed
     */
    public function update(array $set);

    /**
     * get record
     *
     * @param null|array $set
     *
     * @return mixed
     */
    public function select($set = null);

    /**
     * @param null $set
     *
     * @return mixed
     */
    public function delete($set = null);
}
