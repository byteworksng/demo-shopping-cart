<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 1:10 AM
 */

namespace App\Gateway;

use App\Interfaces\DbConnectionInterface;
use App\Interfaces\GatewayInterface;
use App\Interfaces\SessionStorageInterface;

class AbstractGateway implements GatewayInterface
{
    /**
     * An instance DbConnectionInterface | SessionStorageInterface
     *
     * @var
     */
    protected $adapter;


    /**
     * Name of schema
     *
     * @var
     */
    protected $table;

    /**
     * Columns names
     *
     * @var array
     */
    protected $fields = [];

    /**
     * Returned identifier of previously inserted record.
     * only works on DbConnectionInterface.
     *
     * @var int
     */
    protected $lastInsertValue = null;

    /**
     * insert records to schema
     *
     * @param array $params
     *
     * @return array|mixed
     */
    public function insert(array $params)
    {

        $valueArgs = array_values($params);
        $count = count($valueArgs);
        $values = substr(str_repeat('?,', $count), 0, $count + 1);
        $columns = implode(',', array_keys($params));

        $query = "INSERT INTO $this->table ($columns) VALUES ($values)";

        return $this->executeInsert($query, $valueArgs);
    }

    /**
     * @param $query
     * @param $params
     *
     * @return array
     */
    protected function executeInsert($query, $params)
    {
        $result = $this->adapter->execute($query, $params);
        $this->lastInsertValue = $this->adapter->lastInsertId();

        return ['lastInsertId' => $this->lastInsertValue, 'rowCount' => $result->rowCount()];
    }

    /**
     * @param array|null $params
     *
     * @throws  \BadMethodCallException
     */
    public function update(array $params = null)
    {
        $class = get_called_class();
        throw new \BadMethodCallException("update method not implemented for $class");
    }


    /**
     * @param null $id
     *
     * @return mixed
     */
    public function delete($id = null)
    {
        $query = "DELETE FROM $this->table WHERE $this->primary_key = ?";

        return $this->adapter->execute($query, $id);
    }

    /**
     * @param null $param
     *
     * @return mixed
     */
    public function select($param = null)
    {

        if (isset($param))
        {
            $where = [];
            array_walk($param, function (
                /** @noinspection PhpUnusedParameterInspection */
                    $val,
                    $key
            ) use (&$where) {
                array_push($where, "WHERE $key = :$key");
            });

            $where = implode(" AND ", $where);
            $sql = "SELECT * FROM $this->table $where";
            $result = $this->adapter->execute($sql, $param)->fetch();
        } else
        {
            $sql = "SELECT * FROM $this->table";
            $result = $this->adapter->execute($sql)->fetchAll();
        }

        return $result;
    }

    /**
     * Process Raw Sql string, with parameter binding
     *
     * @param string $statement
     * @param array  $param
     *
     * @return mixed
     */
    public function rawSql($statement, $param)
    {
        return $this->adapter->execute($statement, $param);

    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->table;
    }

    /**
     * Get adapter
     *
     * @return DbConnectionInterface|SessionStorageInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * @return int
     */
    public function getLastInsertId()
    {
        return $this->lastInsertValue;
    }

    /**
     * @return array
     */
    public function getFields()
    {
        return $this->fields;
    }

    public function __call($name, $arguments)
    {
        throw new \BadMethodCallException(sprintf('Method %s::%s does not exist.', static::class, $name));
    }
}
