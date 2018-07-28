<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 1:07 AM
 */

namespace App\Gateway;

use App\Interfaces\DbConnectionInterface;

class TableGateway extends AbstractGateway
{
    public function __construct($table, DbConnectionInterface $adapter)
    {
        $this->table = $table;
        $this->adapter = $adapter;
    }
}
