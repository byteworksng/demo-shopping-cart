<?php
/**
 * Authored by Chibuzor Ogbu.
 * Email: chibuzorogbu@gmail.com
 * Date: 11/07/2018
 * Time: 3:04 AM
 */

namespace App\Models\Rating;

use App\Models\Model;

class Rating extends Model
{
    public $id;
    public $productId;
    public $rate;
}
