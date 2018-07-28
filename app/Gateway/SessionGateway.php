<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 2:53 PM
 */

namespace App\Gateway;

use App\Interfaces\GatewayInterface;
use App\Interfaces\SessionStorageInterface;

/**
 * Class SessionGateway
 * Provides api access to manipulate  php global sessions
 *
 * @package App\Gateway
 */
class SessionGateway implements GatewayInterface
{
    /**
     * @var \App\Interfaces\SessionStorageInterface
     */
    public $adapter;

    /**
     * unique identifier for session object
     *
     * @var
     */
    private $sessionKey;

    /**
     * SessionGateway constructor.
     *
     * @param                                         $name
     * @param \App\Interfaces\SessionStorageInterface $adapter
     */
    public function __construct($name, SessionStorageInterface $adapter)
    {
        $this->adapter = $adapter;
        $this->sessionKey = $name;
    }

    /**
     * insert record to session
     *
     * @param array $set
     * @param bool  $shouldCloseSession
     *
     * @return mixed
     */
    public function insert(array $set, $shouldCloseSession = true)
    {
        return $this->adapter->insert($this->sessionKey, $set, $shouldCloseSession);
    }

    /**
     * fetch record from session
     *
     * @param null/array $set
     *
     * @return mixed
     */
    public function select($set = null)
    {
        return $this->adapter->query($this->sessionKey, $set);
    }

    /**
     * completely remove record from session
     *
     * @param null $set
     *
     * @return mixed
     */
    public function delete($set = null)
    {
        return $this->adapter->remove($this->sessionKey, $set);
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        return $this->sessionKey;
    }

    /**
     * update record in session
     * @param array $set
     * @param bool  $shouldCloseSession
     *
     * @return mixed
     */
    public function update(array $set, $shouldCloseSession = true)
    {

        return $this->adapter->update($this->sessionKey, $set, $shouldCloseSession);
    }
}
