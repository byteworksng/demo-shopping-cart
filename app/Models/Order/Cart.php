<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 11/07/2018
 * Time: 2:59 AM
 */

namespace App\Models\Order;

use App\Models\Model;

class Cart extends Model
{
    public $cartId;
    public $name;
    public $orderRef;
    public $img;
    public $qty;
    public $price;
    public $total;
    public $id;
}
