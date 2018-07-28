<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 10/07/2018
 * Time: 7:19 PM
 */
namespace App\Models\Order;

use App\Models\Model;

class Order extends Model
{

    public $gross;
    public $ref;
    public $shipping;
    public $subTotal;
    public $txnId;
}
