<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 09/07/2018
 * Time: 2:33 PM
 */

namespace App\Repository;

use App\Interfaces\GatewayInterface;
use App\Interfaces\RepositoryInterface;
use App\Interfaces\ModelInterface;

abstract class AbstractRepository implements RepositoryInterface
{
    protected $model;

    protected $tableGateway;

    public function __construct(GatewayInterface $tableGateway, ModelInterface $model)
    {
        $this->model = $model;
        $this->tableGateway = $tableGateway;
    }

    /**
     * retrieves records by param
     *
     * @param null $param
     *
     * @return mixed
     */
    function fetch($param)
    {
        return $this->tableGateway->select($param);
    }

    /**
     * retrieves all records
     *
     * @return mixed
     */
    function fetchAll()
    {
        return $this->tableGateway->select();
    }

    /**
     * Adds to record
     *
     * @param array $param
     * @param bool  $shouldCloseSession
     *
     * @return mixed
     */
    function add(array $param, $shouldCloseSession = false)
    {

        return $this->tableGateway->insert($param, $shouldCloseSession);
    }

    /**
     * remove records by param
     *
     * @param array $param
     *
     * @return mixed
     */
    function remove($param)
    {

        $this->tableGateway->delete($param);
    }

    /**
     * removes all records
     *
     * @return mixed
     */
    function removeAll()
    {
        $this->tableGateway->delete();
    }

    /**
     * Update records
     *
     * @param array $param
     * @param bool  $shouldCloseSession
     *
     * @return mixed
     */
    function update($param, $shouldCloseSession = false)
    {
        return $this->tableGateway->update($param, $shouldCloseSession);
    }

    /**
     * returns array of values compatible with target object
     *
     * @param $class
     * @param $param
     *
     * @return array
     */
    protected function parseData($class, $param)
    {

        // check for zero-indexed array
        if (array_keys($param) !== range(0, sizeof($param) - 1))
        {

            return $this->hydrateAndExtract($class, $param);
        }


        return array_map(function ($param) use ($class) {

            return $this->hydrateAndExtract($class, $param);
        }, $param);
    }

    /**
     * @param string|ModelInterface $class
     * @param array                 $resultSet
     *
     * @return ModelInterface[]
     */
    protected function populateAndGet($class, array $resultSet)
    {
        $models = [];
        foreach ($resultSet as $result)
        {
            array_push($models, $class::hydrate($result));
        }

        return $models;
    }

    /**
     * @param $class
     * @param $param
     *
     * @return array
     */
    private function hydrateAndExtract($class, $param)
    {
        if (is_object($class))
        {
            $instance = $class->hydrate($param);
        } else
        {
            $instance = $class::hydrate($param);
        }

        return $instance->extract();
    }
}
