<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 3:08 PM
 */

namespace App\Sessions;

use App\Interfaces\SessionStorageInterface;
use App\Traits\Logger;

/**
 * Class SessionStorage
 *
 * @package App
 */
class SessionStorage implements SessionStorageInterface
{
    use Logger;
    /**
     * @var mixed|null
     */
    private $savePath;

    /**
     * @param string $savePath
     * @return bool
     */
    public function setStoragePath( $savePath = null)
    {
        $this->savePath = $savePath;
        if (! is_dir($this->savePath)) {
            mkdir($this->savePath, 0664);
        }

        session_save_path($this->savePath);
        if (!is_writable(session_save_path())) {
            $this->log('Session path "'.session_save_path().'" is not writable!');
        }


        return true;
    }

    /**
     * @param string $key
     * @param string|null $param
     * @return mixed
     */
    public function query( $key, array $param = null)
    {
        if ($result = $this->getSessionData($key)) {
            if (isset($result) && isset($param)) {

                $result = array_filter($result, function ($set) use ($param) {
                    $matched = array_intersect_assoc($set, $param);

                    return count($matched) == count($param);
                });
            }
        }

        return $result;
    }

    /**
     * @param null $key
     * @return mixed
     */
    private function getSessionData($key = null)
    {

        if (isset($_SESSION[$key])) {
            $data = $_SESSION[$key];
        } else {
            $data = [];
        }

        return $data;
    }

    /**
     * @param string $key
     * @param array|string $data
     * @param bool $shouldCloseSession
     * @return bool
     */
    public function insert( $key, array $data, $shouldCloseSession)
    {

        if ($result = $this->getSessionData($key)) {
            array_push($result, $data);

            return $this->saveSession($key, $result, $shouldCloseSession);
        } else {

            return $this->saveSession($key, [$data], $shouldCloseSession);
        }
    }

    /**
     * @param $key
     * @param $result
     * @param bool $shouldCloseSession
     * @return bool
     */
    private function saveSession($key, $result, $shouldCloseSession = false)
    {

        $connection = $this->write($key, $result);
        if ($shouldCloseSession) {
            return $connection->close();
        }

        return true;
    }

    /**
     * @param $sessionKey
     * @param array $data
     * @return $this
     */
    private function write($sessionKey, array $data)
    {
        $_SESSION[$sessionKey] = $data;

        return $this;
    }

    /**
     * @return bool
     */
    private function close()
    {
        session_write_close();

        return true;
    }

    /**
     * @param string $key
     * @param string|array $data
     * @param bool $shouldCloseSession
     * @return bool
     */
    public function update( $key, array $data, $shouldCloseSession)
    {

        if ($result = $this->getSessionData($key)) {

            foreach ($data as $identifier => $value) {
                if (array_key_exists($identifier, $result)) {
                    $result[$identifier] = $value;
                }
            }

            return $this->saveSession($key, $result, $shouldCloseSession);
        }

        return false;
    }

    /**
     * remove item/s from session
     *
     * @param \string $key
     * @param null $param
     * @param bool $shouldCloseSession
     * @return bool
     */
    public function remove( $key, $param = null, $shouldCloseSession=false)
    {
        if (empty($param)) {
            if (isset($_SESSION[$key])) {
                unset($_SESSION[$key]);
                return true;
            }
        } else {
            $result = $this->query($key, $param);

            if (! empty($result)) {
                $session = $this->getSessionData($key);
                foreach ($result as $row){

                    array_splice($session,  array_search($row, $session), 1);
                }

               return $this->saveSession($key, $session, $shouldCloseSession);

            }
        }

        return false;
    }

    public function __call($name, $arguments)
    {
        if (! isset($_SESSION)) {
            throw new \RuntimeException("Session has not been created");
        }
    }
}
