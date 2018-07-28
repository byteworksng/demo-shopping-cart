<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 14/07/2018
 * Time: 12:08 AM
 */

namespace App\Models\Wallet;

use App\Models\Model;

class Wallet extends Model
{
    protected $cash;

    /**
     * @return mixed
     */
    public function getCash()
    {
        return $this->cash;
    }

    /**
     * @param mixed $cash
     */
    public function setCash($cash)
    {
        $this->cash = $cash;
    }


}
