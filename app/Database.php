<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 02/07/2018
 * Time: 3:24 PM
 */

namespace App;

use App\Interfaces\DbConnectionInterface;
use PDO;

class Database extends PDO implements DbConnectionInterface
{
    private static $instance;

    public function __construct($dsn, $username, $password, $pdoOptions = [])
    {
        $default_options = [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        ];
        $options = array_replace($default_options, $pdoOptions);
        parent::__construct($dsn, $username, $password, $options);
        self::$instance = $this;


    }

    public static function getConnection()
    {
        return self::$instance;
    }

    public function execute($sql, array $args = null)
    {
        if ( ! $args)
        {
            return $this->query($sql);
        }
        $stmt = $this->prepare($sql);

        $stmt->execute($args);

        return $stmt;

    }

}
