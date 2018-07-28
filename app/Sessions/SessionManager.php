<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 28/06/2018
 * Time: 2:18 AM
 */

namespace App\Sessions;

use App\Config;
use App\Interfaces\BootstrapInterface;
use App\Interfaces\SessionInterface;
use App\Interfaces\SessionStorageInterface;

/**
 * Class SessionManager
 *
 * @package App\Session
 */
class SessionManager implements SessionInterface, BootstrapInterface
{
    private $session;

    private $sessionPath;

    public function __construct(SessionStorageInterface $session, Config $config)
    {
        $this->session = $session;
        $this->sessionPath = $config->get('sessionStoragePath');
    }

    /**
     * @return $this
     */
    public function end()
    {
        session_unset();
        session_destroy();

        return $this;
    }

    /**
     *
     */
    public function run()
    {
        if ($this->getSessionStatus() == PHP_SESSION_NONE)
        {
            $this->start();
        }
    }

    /**
     * @return int
     */
    public function getSessionStatus()
    {
        return session_status();
    }

    /**
     * @return $this
     */
    public function start()
    {
        $this->session->setStoragePath($this->sessionPath);
        session_start();

        return $this;
    }
}
